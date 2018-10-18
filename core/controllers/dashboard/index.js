$(document).ready(function(){
    online();
    seleccionar_postulantes_x_carrera();
    seleccionar_solicitudes_x_estado();
});

//metodo para obtener en un arreglo, todos los elementos de una posicion de otro arreglo
function getToArray(data, posicion){
    //lo que retornaremos
    var retornar = [];
    //el foreach del arreglo
    data.forEach(item => {
        //si es que hay algo personalizado se utiliza este
        switch (posicion) {
            //por carrera, el grafico por carrera es de pastel, utiliza una estructura diferente
            case "x_carrera":
                //le agregamos una nueva posicion al rreglo, que es otro arreglo, con las posiciones value y name
                retornar.push({value: item["Cantidad"], name: item["Carrera"]});
                break;
                
            default:
                //al arreglo le agregamos el elemento del arreglo en la posicion especificada
                retornar.push(item[posicion]);
                break;
        }
    });
    return retornar;
};

//hace la peticion para obtener la informacion necesaria para el grafico
function seleccionar_solicitudes_x_estado(){
    $.ajax({
        type: "POST",
        data: null,
        url: "../../core/controllers/scripts/detalles.php?accion=contar_solicitudes_x_estado",
        success: function (respuesta) {
            if(respuesta.registros.length > 0){
                //si trajo registros, inicializa el grafico
                grafico1(respuesta.registros);
            }
        }, error: function(respuesta){
            console.log("Error:");
            console.log(respuesta);
        }
    });
}

//hace la peticion para obtener la informacion necesaria para el grafico
function seleccionar_postulantes_x_carrera(){
    $.ajax({
        type: "POST",
        data: null,
        url: "../../core/controllers/scripts/detalles.php?accion=contar_postulantes_x_carrera",
        success: function (respuesta) {
            if(respuesta.registros.length > 0){
                //si trajo registros, inicializa el grafico
                grafico2(respuesta.registros);
            }
        }, error: function(respuesta){
            console.log("Error:");
            console.log(respuesta);
        }
    });
}

//el primer grafico, de barras
function grafico1(arreglo){
    //especificamos que parte del dom sera la que afectaremos
    var dom = document.getElementById("grafico_1");
    //obtenemos el objeto de echarts
    var myChart = echarts.init(dom);
    var option = null;
    //comienza la configuracion del grafico
    option = {
        //los colores de las barras
        color: ["#3398DB"],
        //especificamos que tendra el titulo
        title: {
            text: "Cantidad de solicitudes por estado",
            x:"center",
            textStyle: { fontSize: "20" },
        },
        //si tendra tooltips y que mostrara
        tooltip : {
            trigger: "axis",
            axisPointer : {
                type : "shadow"
            }
        },
        //la caja de herramientas, para descargar o cambiar de tipo de grafico
        toolbox: {
            show: true,
            left: 0,
            top: 25,
            orient: "horizontal",
            feature: {
                magicType: { show: true, title: "Cambiar", type: ["line", "bar"] },
                saveAsImage: { show: true, title: "Descargar" }
            },
        },
        calculable: true,
        //especificando que tan adentro del div comenzara el grafico
        grid: {
            left: "3%",
            right: "4%",
            bottom: "3%",
            containLabel: true
        },
        //las categorias, es decir, cada columna
        xAxis: {
            type: "category",
            //obtenemos en un arreglo todos los elementos que vienen en la posicion "Estado"
            data: getToArray(arreglo, "Estado"),
        },
        yAxis: {
            type: "value"
        },
        //los numeros estadisticos ya
        series: [{
            //obtenemos en un arreglo todos los elementos que vienen en la posicion "Cantidad"
            data: getToArray(arreglo, "Cantidad"),
            type: "bar"
        }]
    };;
    //si la option es un object, por tener tantos arreglos en arreglos, lo es 
    if (option && typeof option === "object") {
        //seteamos las option, la configuracion, al grafico
        myChart.setOption(option, true);

        //propiedad para hacer al grafico responsive, cada vez que cambie la ventana
        //el grafico se redimencionara ajustandose a su contenedor
        window.addEventListener("resize", function(){
            if(myChart != null && myChart != undefined){
                myChart.resize();
            }
        });
    }
}

//grafico de pastel 
function grafico2(arreglo){
    //especificamos que parte del dom afectara
    var dom = document.getElementById("grafico_2");
    //obtenemos un objeto de echarts
    var myChart2 = echarts.init(dom);
    var option = null;
    //configuracion del grafico
    option = {
        //lo que tendra en el titulo
        title: {
            text: "Cantidad de solicitudes por carrera",
            subtext: "Solo solicitudes finalizadas",
            textStyle: { fontSize: "20"},
            x:"center"
        },
        //tendra tooltips, los {a} {b} {c} {d} son variables referente a la serie sobre la que este el mouse
        tooltip : {
            trigger: "item",
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        //caja de herramientas para descargar el grafico como imagen
        toolbox: {
            show: true,
            feature: {
                saveAsImage: { show: true, title: "Descargar" }
            },
            right: 20,
            top: 25,
            orient: "vertical",
        },
        //las legendas del grafico
        legend: {
            orient: "horizontal",
            left: "left",
            top:60,
            //obtenemos en un arreglo todos los items que esten en la posicion carrera
            data: getToArray(arreglo, "Carrera"),
        },
        //seris del grafico y configuracion del mismo
        series : [
            {
                name: "Carrera",
                //especificamos de que tipo sera el grafico
                type: "pie",
                //el radio que tendra, el 50% de su cntenedor
                radius : "50%",
                //para moverlo, 50% 50% es para centrarlo
                center: ["50%", "50%"],
                //obtenemos un arreglo con formato especifico de getToArray
                data: getToArray(arreglo, "x_carrera"),
            }
        ]
    };
    //si la option es un object, por tener tantos arreglos en arreglos, lo es 
    if (option && typeof option === "object") {
        //seteamos las option, la configuracion, al grafico
        myChart2.setOption(option, true);

        //propiedad para hacer al grafico responsive, cada vez que cambie la ventana
        //el grafico se redimencionara ajustandose a su contenedor
        window.addEventListener("resize", function(){
            if(myChart2 != null && myChart2 != undefined){
                myChart2.resize();
            }
        });
    }
}