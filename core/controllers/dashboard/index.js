$(document).ready(function(){
    window.setTimeout(function(){
        online();
    }, 100);
    seleccionar_postulantes_x_carrera();
    seleccionar_solicitudes_x_estado();
});

function getToArray(data, posicion){
    var retornar = [];
    data.forEach(item => {
        switch (posicion) {
            case "x_carrera":
                retornar.push({value: item["Cantidad"], name: item["Carrera"]});
                break;
                
            default:
                retornar.push(item[posicion]);
                break;
        }
    });
    return retornar;
};

function seleccionar_solicitudes_x_estado(){
    $.ajax({
        type: "POST",
        data: null,
        url: "../../core/controllers/scripts/detalles.php?accion=contar_solicitudes_x_estado",
        success: function (respuesta) {
            if(respuesta.registros.length > 0){
                grafico1(respuesta.registros);
            }
        }, error: function(respuesta){
            console.log("Error:");
            console.log(respuesta);
        }
    });
}

function seleccionar_postulantes_x_carrera(){
    $.ajax({
        type: "POST",
        data: null,
        url: "../../core/controllers/scripts/detalles.php?accion=contar_postulantes_x_carrera",
        success: function (respuesta) {
            if(respuesta.registros.length > 0){
                grafico2(respuesta.registros);
            }
        }, error: function(respuesta){
            console.log("Error:");
            console.log(respuesta);
        }
    });
}

function grafico1(arreglo){
    var dom = document.getElementById("grafico_1");
    var myChart = echarts.init(dom);
    var app = {};
    var option = null;
    option = {
        color: ["#3398DB"],
        title: {
            text: "Cantidad de solicitudes por estado",
            textStyle: { fontSize: "20" },
            x:"center"
        },
        tooltip : {
            trigger: "axis",
            axisPointer : {
                type : "shadow"
            }
        },
        toolbox: {
            show: true,
            feature: {
                magicType: { show: true, title: "Cambiar", type: ["line", "bar"] },
                saveAsImage: { show: true, title: "Descargar" }
            },
            left: 0,
            top: 25,
            orient: "horizontal",
        },
        calculable: true,
        grid: {
            left: "3%",
            right: "4%",
            bottom: "3%",
            containLabel: true
        },
        xAxis: {
            type: "category",
            data: getToArray(arreglo, "Estado"),
        },
        yAxis: {
            type: "value"
        },
        series: [{
            data: getToArray(arreglo, "Cantidad"),
            type: "bar"
        }]
    };;
    if (option && typeof option === "object") {
        myChart.setOption(option, true);

        window.addEventListener("resize", function(){
            if(myChart != null && myChart != undefined){
                myChart.resize();
            }
        });
    }
}


function grafico2(arreglo){
    var dom = document.getElementById("grafico_2");
    var myChart2 = echarts.init(dom);
    var app = {};
    var option = null;
    option = {
        title: {
            text: "Cantidad de solicitudes por carrera",
            textStyle: { fontSize: "20"},
            x:"center"
        },
        tooltip : {
            trigger: "item",
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        toolbox: {
            show: true,
            feature: {
                saveAsImage: { show: true, title: "Descargar" }
            },
            left: 0,
            top: 25,
            orient: "horizontal",
        },
        legend: {
            orient: "vertical",
            left: "left",
            top:60,
            data: getToArray(arreglo, "Carrera"),
        },
        series : [
            {
                name: "Carrera",
                type: "pie",
                radius : "55%",
                center: ["60%", "50%"],
                data: getToArray(arreglo, "x_carrera"),
                itemStyle: {
                    emphasis: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: "rgba(0, 0, 0, 0.5)"
                    }
                }
            }
        ]
    };;
    if (option && typeof option === "object") {
        myChart2.setOption(option, true);

        window.addEventListener("resize", function(){
            if(myChart2 != null && myChart2 != undefined){
                myChart2.resize();
            }
        });
    }
}