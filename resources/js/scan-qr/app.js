var app=(function() {
    'use strict';
    var that=this;
    return {
        dom:{},
        variables:{},
        videoSelect:document.querySelector("select#VideoSource"),
        selectors:[],
        setVariables:function(initVar) {
            this.variables.constraintVideo={'video':{},'audio':false};
            this.variables.Interval=100;
            this.variables.UsingJSQR=true;
        },
        getReferences:function() {
            this.videoSelect=$('#VideoSource').get(0);
            this.videoSelect.jq=$('#VideoSource');
            this.selectors.push(this.videoSelect);
            this.dom.VisorVideo=$('#VisorVideo').get(0);
            this.dom.VisorVideo.jq=$('#VisorVideo');
            this.dom.VisorVideo.jq.hide();
            this.dom.Lienzo=$('#qr-canvas').get(0);
            this.dom.Lienzo.jq=$('#qr-canvas');
            this.dom.TBoxResultado=$('#TextBIDI').get(0);
            this.dom.TBoxResultado.jq=$('#TextBIDI');
        },
        setEvents:function() {
            var that=this;
            this.videoSelect.jq.on('change',function(event) {
                app.initMediaEvents();
            });
            this.dom.TBoxResultado.jq.on('change',$.proxy(app.onDetectaDatoQR,this));
        },
        init:function(initVar) {
            this.setVariables(initVar);
            this.getReferences();
            this.setEvents();
        },
        getSourceVideo:function() {
            navigator.mediaDevices.enumerateDevices().then(this.gotDevices).catch(function(error) {
                alert(error.message);
            });
        },
        gotDevices:function(deviceInfos) {
            const values = app.selectors.map(select => select.value);
            app.selectors.forEach(select => {
                while (select.firstChild) {
                    select.removeChild(select.firstChild);
                }
            });
            for (let i = 0; i !== deviceInfos.length; ++i) {
                const deviceInfo = deviceInfos[i];
                const option = document.createElement('option');
                option.value = deviceInfo.deviceId;
                if(deviceInfo.kind=="videoinput") {
                    option.text= deviceInfo.label || `camera ${videoSelect.length + 1}`;
                    app.videoSelect.appendChild(option);
                } else {
                    console.log('Some other kind of source/device: ', deviceInfo);

                }
            }
            app.selectors.forEach((select, selectorIndex) => {
                if (Array.prototype.slice.call(select.childNodes).some(n => n.value === values[selectorIndex])) {
                select.value = values[selectorIndex];
                }
            });
            app.initMediaEvents();
        },
        initCanvas:function(ancho,alto) {
            this.dom.Lienzo.style.width=ancho+"px";
            this.dom.Lienzo.style.height=alto+"px";
            this.dom.Lienzo.width=ancho;
            this.dom.Lienzo.height=alto;
            this.dom.Lienzo.Ctx2D=this.dom.Lienzo.getContext("2d");
            this.dom.Lienzo.Ctx2D.clearRect(0,0,ancho,alto);
        },
        initMediaEvents:function() {
            app.variables.constraintVideo.video.deviceId= app.videoSelect.value?{exact:app.videoSelect.value}:undefined;
            this.getUserMedia(app.variables.constraintVideo, function(stream) {
                debugger;
                app.initCanvas(app.dom.VisorVideo.width>0?app.dom.VisorVideo.width:240,app.dom.VisorVideo.height>0?app.dom.VisorVideo.height:180);
                if('srcObject' in app.dom.VisorVideo) {
                    app.dom.VisorVideo.srcObject=stream;
                    try {
                    app.dom.VisorVideo.src=(window.URL || window.webkitURL).createObjectURL(stream);
                    } catch (e) {
                        console.log(e);
                    }
                } else if(navigator.mozGetUserMedia) {
                    app.dom.VisorVideo.mozSrcObject=stream;
                }
                app.CaptureToCanvas();
            },
            function (err) {});
        },
        getUserMedia:function(options, success, fail) {
            var api=navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia|| navigator.msGetUserMedia;
            if(api) {
                return api.bind(navigator)(options,success,fail);
            } else {
                fail({message:"No se ha podido cargar el objeto navegador"});
                return null;
            }
        },
        CaptureToCanvas:function() {
            try {
                app.dom.Lienzo.Ctx2D.drawImage(app.dom.VisorVideo,0,0,app.dom.VisorVideo.width>0?app.dom.VisorVideo.width:240,app.dom.VisorVideo.height>0?app.dom.VisorVideo.height:180);
                if(!app.variables.UsingJSQR) {
                    try {
                        qrcode.onGetResult=app.GetQrResults;
                        qrcode.callback=app.GetQrResults;
                        qrcode.decode();
                    } catch(e) {}
                } else {
                    try {
                        var imageData=app.dom.Lienzo.Ctx2D.getImageData(0, 0,app.dom.VisorVideo.width>0?app.dom.VisorVideo.width:240,app.dom.VisorVideo.height>0?app.dom.VisorVideo.height:180);
                        var code=jsQR(imageData.data,imageData.width,imageData.height,{
                            inversionAttempts: "dontInvert"
                        });
                        if(code) {
                            app.GetQrResults(code.data);
                        }
                    } catch (e) {}
                }
            } catch(e) {}
            setTimeout(app.CaptureToCanvas,app.variables.Interval);
        },
        GetQrResults:function(decodeResult) {
            if(decodeResult!==null){
                app.dom.TBoxResultado.value=decodeResult;
                app.dom.VisorVideo.pause();
                app.dom.VisorVideo.srcObject = null;
                if (app.dom.VisorVideo.srcObject) {
                    let tracks = app.dom.VisorVideo.srcObject.getTracks();
                    tracks.stop();
                }
                app.dom.Lienzo.Ctx2D.clearRect(0, 0, app.dom.Lienzo.width, app.dom.Lienzo.height);
                //console.log(decodeResult);
                var form = document.getElementById("form-qr");
                form.submit();
            }
        },
        onDetectaDatoQR:function(event) {
            if(app.dom.TBoxResultado.value!="") {
                alert("Llamamos al controlador con "+app.dom.TBoxResultado.value)
            }
        }
    };
})();

$(document).ready(function() {
    app.init({});
    $('#btnEncenderCamara').on('click', function() {
        navigator.mediaDevices.getUserMedia({ video: true })
        .then(function(stream) {
            app.getSourceVideo();
            $('#btn-scan-qr').hide();
            app.dom.VisorVideo.jq.show();
        })
        .catch(function(error) {
            console.error('Error al solicitar permisos para la cámara:', error);
        });
    });
    $('#btnApagarCamara').on('click', function() {
        app.dom.VisorVideo.pause();
        app.dom.VisorVideo.srcObject = null;
        if (app.dom.VisorVideo.srcObject) {
            let tracks = app.dom.VisorVideo.srcObject.getTracks();
            tracks.stop();
        }
        app.dom.Lienzo.Ctx2D.clearRect(0, 0, app.dom.Lienzo.width, app.dom.Lienzo.height);
        $('#btn-scan-qr').show();
        app.dom.VisorVideo.jq.hide();
    });
});
