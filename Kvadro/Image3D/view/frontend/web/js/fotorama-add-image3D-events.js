define([
    'jquery',
    'jquery/ui',
    'catalogGallery',
    'loadPlayer'
], function ($) {
    'use strict';

    function load3DFrame(iframe_url) {
        return "<iframe width='100%'" +
            "height='600px'" +
            "frameborder='0'" +
            "allowfullscreen" +
            "mozallowfullscreen='true'" +
            "webkitallowfullscreen='true'" +
            "style='border:0;'" +
            "src='" + iframe_url +
            "?autorun=0" +
            "&closebutton=1" +
            "&logo=1" +
            "&autorotate=0" +
            "&autorotatetime=10" +
            "&autorotatedelay=2" +
            "&autorotatedir=1" +
            "&hidefullscreen=1" +
            "&hideautorotateopt=1" +
            "&hidesettingsbtn=0" +
            "&enableimagezoom=1" +
            "&zoomquality=1" +
            "&hidezoomopt=0'>" +
            "</iframe>";
    }

    //create AddFotoramaImage3DEvents widget
    $.widget('mage.AddFotoramaImage3DEvents', {
        /**
         * Creates widget
         * @private
         */
        _create: function () {
            var render=false;
            $(this.element).on('fotorama:load', function fotorama_onLoad(e, fotorama) {
                if (!render) {
                    if (fotorama.data[0]['type'] == "image3D") {
                        var iframe_url = fotorama.data[0]['videoUrl'];
                        var iframe3D = load3DFrame(iframe_url);
                        fotorama.data[0].$stageFrame[0].innerHTML = iframe3D;
                        render=true;
                    }
                }
            });
        },

    });

    return $.mage.AddFotoramaImage3DEvents;
});
