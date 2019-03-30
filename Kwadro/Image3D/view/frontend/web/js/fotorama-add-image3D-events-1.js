/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'jquery',
    'jquery/ui',
    'catalogGallery',
    'loadPlayer'
], function ($) {
    'use strict';

    /**
     * @private
     */
    var allowBase = true; //global var is needed because fotorama always fully reloads events in case of fullscreen
    $.widget('mage.AddFotoramaImage3DEvents1', {
        options: {
            videoData: '',
            videoSettings: '',
            optionsVideoData: '',
            dataMergeStrategy: 'replace',
            vimeoJSFrameworkLoaded: false
        },

        /**
         * @private
         */
        onVimeoJSFramework: function () {
        },

        /**
         * Creates widget
         * @private
         */
        _create: function () {
            $(this.element).on('gallery:loaded', $.proxy(function () {
                this.fotoramaItem = $(this.element).find('.fotorama-item');
                this._initialize();
            }, this));
        },

        /**
         *
         * @private
         */
        _initialize: function () {
            if (!this.defaultVideoData.length) {
                this.defaultVideoData = this.options.videoData;
            }

            // If product does not have images, no video data generated,
            // but for configurable product we still need a video data, in case of 'prepend' gallery strategy.
            if (!this.defaultVideoData.length && !this.options.videoData.length) {
                this.defaultVideoData = this.options.videoData = this.videoDataPlaceholder;
            }
            console.log('_initialize');
            console.log(this.defaultVideoData);
            this.clearEvents();

            if (this._checkForVideoExist()) {
                this._initFotoramaVideo();
            }
        },

        /**
         * Clear gallery events to prevent duplicated calls.
         *
         * @private
         */
        clearEvents: function () {
            console.log('clearEvents');
            console.log(this.PV);
            console.log('fotorama:show.' + this.PV);

            this.fotoramaItem.off(
                'fotorama:show.' + this.PV +
                ' fotorama:showend.' + this.PV +
                ' fotorama:fullscreenenter.' + this.PV +
                ' fotorama:fullscreenexit.' + this.PV
            );
        },

        /**
         *
         * @param {Object} options
         * @private
         */
        _setOptions: function (options) {
            if (options.videoData && options.videoData.length) {
                this.options.videoData = options.videoData;
            }

            this._loadVideoData(options);
            this._initialize();
        },

        /**
         * Set video data for configurable product.
         *
         * @param {Object} options
         * @private
         */
        _loadVideoData: function (options) {
            if (options.selectedOption) {
                if (options.dataMergeStrategy === 'prepend') {
                    this.options.videoData = [].concat(
                        this.options.optionsVideoData[options.selectedOption],
                        this.defaultVideoData
                    );
                } else {
                    this.options.videoData = this.options.optionsVideoData[options.selectedOption];
                }
            } else {
                this.options.videoData = this.defaultVideoData;
            }
        },

        /**
         *
         * @private
         */
        _checkFullscreen: function () {
            if (this.fotoramaItem.data('fotorama').fullScreen || false) {
                this.isFullscreen = true;
            }
        },

        /**
         *
         * @private
         */
        _listenForFullscreen: function () {
            this.fotoramaItem.on('fotorama:fullscreenenter.' + this.PV, $.proxy(function () {
                this.isFullscreen = true;
            }, this));

            this.fotoramaItem.on('fotorama:fullscreenexit.' + this.PV, $.proxy(function () {
                this.isFullscreen = false;
                this._hideVideoArrows();
            }, this));
        },

        /**
         *
         * @param {Object} inputData
         * @param {bool} isJSON
         * @returns {{}}
         * @private
         */
        _createVideoData: function (inputData, isJSON) {
            var videoData = [],
                dataUrl,
                tmpVideoData,
                tmpInputData,
                i;

            if (isJSON) {
                inputData = $.parseJSON(inputData);
            }

            for (i = 0; i < inputData.length; i++) {
                tmpInputData = inputData[i];
                dataUrl = '';
                tmpVideoData = {
                    mediaType: '',
                    isBase: '',
                    id: '',
                    provider: ''
                };
                tmpVideoData.mediaType = this.VID;

                if (tmpInputData.mediaType !== 'external-video') {
                    tmpVideoData.mediaType = tmpInputData.mediaType;
                }

                tmpVideoData.isBase = tmpInputData.isBase;

                if (tmpInputData.videoUrl && tmpInputData.videoUrl !== null) {
                    if (tmpVideoData.mediaType == "image3D") {
                        tmpVideoData.id = '1';
                        tmpVideoData.provider = 'kvadro';
                        tmpVideoData.videoUrl = tmpInputData.videoUrl;

                    } else {
                        dataUrl = tmpInputData.videoUrl;
                        dataUrl = parseURL(dataUrl);
                        tmpVideoData.id = dataUrl.id;
                        tmpVideoData.provider = dataUrl.type;
                        tmpVideoData.videoUrl = tmpInputData.videoUrl;
                        tmpVideoData.useYoutubeNocookie = dataUrl.useYoutubeNocookie;

                    }

                }

                videoData.push(tmpVideoData);
            }

            return videoData;
        },

        /**
         *
         * @param {Object} fotorama
         * @param {bool} isBase
         * @private
         */
        _createCloseVideo: function (fotorama, isBase) {
            var closeVideo;

            this.fotoramaItem.find('.' + this.FTVC).remove();
            this.fotoramaItem.append('<div class="' + this.FTVC + '"></div>');
            this.fotoramaItem.css('position', 'relative');
            closeVideo = this.fotoramaItem.find('.' + this.FTVC);
            this._closeVideoSetEvents(closeVideo, fotorama);

            if (
                isBase &&
                this.options.videoData[fotorama.activeIndex].isBase &&
                $(window).width() > this.MobileMaxWidth) {
                this._showCloseVideo();
            }
        },

        /**
         *
         * @private
         */
        _hideCloseVideo: function () {
            this.fotoramaItem
                .find('.' + this.FTVC)
                .removeClass('fotorama-show-control');
        },

        /**
         *
         * @private
         */
        _showCloseVideo: function () {
            this.fotoramaItem
                .find('.' + this.FTVC)
                .addClass('fotorama-show-control');
        },

        /**
         *
         * @param {jQuery} $closeVideo
         * @param {jQuery} fotorama
         * @private
         */
        _closeVideoSetEvents: function ($closeVideo, fotorama) {
            $closeVideo.on('click', $.proxy(function () {
                this._unloadVideoPlayer(fotorama.activeFrame.$stageFrame.parent(), fotorama, true);
                this._hideCloseVideo();
            }, this));
        },

        /**
         *
         * @returns {Boolean}
         * @private
         */
        _checkForVideoExist: function () {

            var key, result, checker, videoSettings;
            console.log('_checkForVideoExist videoData');
            console.log(this.options.videoData);
            console.log('_checkForVideoExist videoSettings');
            console.log(this.options.videoSettings);


            if (!this.options.videoData) {
                return false;
            }

            if (!this.options.videoSettings) {
                return false;
            }

            result = this._createVideoData(this.options.videoData, false);

            console.log('_checkForVideoExist _createVideoData result ');
            console.log(result);

            console.log('_checkForVideoExist this.VID ');
            console.log(this.VID);

            checker = false;
            videoSettings = this.options.videoSettings[0];

            videoSettings.playIfBase = parseInt(videoSettings.playIfBase, 10);
            videoSettings.showRelated = parseInt(videoSettings.showRelated, 10);
            videoSettings.videoAutoRestart = parseInt(videoSettings.videoAutoRestart, 10);

            for (key in result) {
                if (result[key].mediaType === this.VID || result[key].mediaType == 'image3D') {
                    checker = true;
                }
            }

            if (checker) {
                this.options.videoData = result;
            }

            console.log('_checkForVideoExist checker ');
            console.log(checker);

            return checker;
        },

        /**
         *
         * @private
         */
        _checkForVimeo: function () {
            var allVideoData = this.options.videoData,
                videoItem;

            if (window.Froogaloop) { // prevent duplicated initialization
                return;
            }

            for (videoItem in allVideoData) {
                if (allVideoData[videoItem].provider === this.VI) {
                    this._loadVimeoJSFramework();

                    return;
                }
            }
        },

        /**
         *
         * @private
         */
        _isVideoBase: function () {
            var allVideoData = this.options.videoData,
                videoItem,
                allVideoDataKeys,
                key,
                i;

            allVideoDataKeys = Object.keys(allVideoData);

            for (i = 0; i < allVideoDataKeys.length; i++) {
                key = allVideoDataKeys[i];
                videoItem = allVideoData[key];

                if (
                    videoItem.mediaType === this.VID && videoItem.isBase &&
                    this.options.videoSettings[0].playIfBase && allowBase
                ) {
                    this.Base = true;
                    allowBase = false;
                }
            }

            if (!this.isFullscreen) {
                this._createCloseVideo(this.fotoramaItem.data('fotorama'), this.Base);
            }
        },

        /**
         *
         * @private
         */
        _loadVimeoJSFramework: function () {
            var element = document.createElement('script'),
                scriptTag = document.getElementsByTagName('script')[0];

            element.async = true;
            element.src = 'https://f.vimeocdn.com/js/froogaloop2.min.js';

            /**
             * Vimeo js framework on load callback.
             */
            element.onload = function () {
                this.onVimeoJSFramework();
                this.vimeoJSFrameworkLoaded = true;
            }.bind(this);
            scriptTag.parentNode.insertBefore(element, scriptTag);
        },

        /**
         *
         * @param {Event} e
         * @private
         */
        _initFotoramaVideo: function (e) {
            var fotorama = this.fotoramaItem.data('fotorama'),
                thumbsParent,
                thumbs,
                t;

            if (!fotorama.activeFrame.$navThumbFrame) {
                this.fotoramaItem.on('fotorama:showend.' + this.PV, $.proxy(function (evt, fotoramaData) {
                    $(fotoramaData.activeFrame.$stageFrame).removeAttr('href');
                }, this));

                this._startPrepareForPlayer(e, fotorama);

                return null;
            }

            fotorama.data.map($.proxy(this._setItemType, this));
            thumbsParent = fotorama.activeFrame.$navThumbFrame.parent();
            thumbs = thumbsParent.find('.fotorama__nav__frame:visible');

            for (t = 0; t < thumbs.length; t++) {
                this._setThumbsIcon(thumbs.eq(t), t);
                this._checkForVideo(e, fotorama, t + 1);
            }

            this.fotoramaItem.on('fotorama:showend.' + this.PV, $.proxy(function (evt, fotoramaData) {
                $(fotoramaData.activeFrame.$stageFrame).removeAttr('href');
            }, this));
        },

        /**
         *
         * @param {Object} elem
         * @param {Number} i
         * @private
         */
        _setThumbsIcon: function (elem, i) {
            var fotorama = this.fotoramaItem.data('fotorama');

            if (fotorama.options.nav === 'dots' && elem.hasClass(this.TI)) {
                elem.removeClass(this.TI);
            }

            if (fotorama.options.nav === 'dots' && elem.hasClass('image3D')) {
                elem.removeClass('image3D');
            }
            /*console.log('_setThumbsIcon fotorama.options.nav ');
            console.log(fotorama.options.nav);
            console.log('_setThumbsIcon this.TI ');
            console.log(this.TI);*/

            if (this.options.videoData[i].mediaType === this.VID &&
                fotorama.data[i].type === this.VID &&
                fotorama.options.nav === 'thumbs') {
                elem.addClass(this.TI);
            }
            if (this.options.videoData[i].mediaType === 'image3D' &&
                fotorama.data[i].type === 'image3D' &&
                fotorama.options.nav === 'thumbs') {
                elem.addClass('image3D-thumb-icon');
            }
        },

        /**
         * Temporary solution with adding types for configurable product items
         *
         * @param {Object} item
         * @param {Number} i
         * @private
         */
        _setItemType: function (item, i) {
            !item.type && (item.type = this.options.videoData[i].mediaType);
        },

        /**
         * Attach
         *
         * @private
         */
        _attachFotoramaEvents: function () {
            this.fotoramaItem.on('fotorama:showend.' + this.PV, $.proxy(function (e, fotorama) {
                this._startPrepareForPlayer(e, fotorama);
            }, this));

            this.fotoramaItem.on('fotorama:show.' + this.PV, $.proxy(function (e, fotorama) {
                this._unloadVideoPlayer(fotorama.activeFrame.$stageFrame.parent(), fotorama, true);
            }, this));

            this.fotoramaItem.on('fotorama:fullscreenexit.' + this.PV, $.proxy(function (e, fotorama) {
                fotorama.activeFrame.$stageFrame.find('.' + this.PV).remove();
                this._startPrepareForPlayer(e, fotorama);
            }, this));
        },

        /**
         * Start prepare for player
         *
         * @param {Event} e
         * @param {jQuery} fotorama
         * @private
         */
        _startPrepareForPlayer: function (e, fotorama) {

            this._unloadVideoPlayer(fotorama.activeFrame.$stageFrame.parent(), fotorama, false);
            this._checkForVideo(e, fotorama, fotorama.activeFrame.i);
            this._checkForVideo(e, fotorama, fotorama.activeFrame.i - 1);
            this._checkForVideo(e, fotorama, fotorama.activeFrame.i + 1);
        },

        /**
         * Check for video
         *
         * @param {Event} e
         * @param {jQuery} fotorama
         * @param {Number} number
         * @private
         */
        _checkForVideo: function (e, fotorama, number) {

            var videoData = this.options.videoData[number - 1],
                $image = fotorama.data[number - 1];
            console.log('_checkForVideo number');
            console.log(number);
            console.log('_checkForVideo $image.type');
            console.log($image.type);

            if ($image) {
                !$image.type && this._setItemType($image, number - 1);



                if ($image.type === 'image') {
                    $image.$navThumbFrame && $image.$navThumbFrame.removeClass(this.TI);
                    this._hideCloseVideo();

                    return;
                } else if ($image.$navThumbFrame && $image.type === 'video') {
                    !$image.$navThumbFrame.hasClass(this.TI) && $image.$navThumbFrame.addClass(this.TI);
                }
                else if ($image.$navThumbFrame && $image.type === 'image3D') {
                    !$image.$navThumbFrame.hasClass('image3D-thumb-icon') && $image.$navThumbFrame.addClass('image3D-thumb-icon');
                }
                $image = $image.$stageFrame;
            }

            if ($image && videoData && videoData.mediaType === this.VID) {

                console.log($(fotorama.activeFrame.$stageFrame));
                $(fotorama.activeFrame.$stageFrame).removeAttr('href');
                this._prepareForVideoContainer($image, videoData, fotorama, number);
            }


            if ($image && videoData && videoData.mediaType === "image3D") {
                console.log('_prepareForImage3DContainer');
                console.log(videoData);
                console.log(number);
                console.log($(fotorama.activeFrame.$stageFrame));

                $(fotorama.activeFrame.$stageFrame).removeAttr('href');

                this._prepareForImage3DContainer($image, videoData, fotorama, number);
            }
            if (this.isFullscreen && this.fotoramaItem.data('fotorama').activeFrame.i === number) {
                this.fotoramaItem.data('fotorama').activeFrame.$stageFrame[0].click();
            }
        },

        /**
         * Prepare for video container
         *
         * @param {jQuery} $image
         * @param {Object} videoData
         * @param {Object} fotorama
         * @param {Number} number
         * @private
         */
        _prepareForVideoContainer: function ($image, videoData, fotorama, number) {
            $image.addClass('fotorama-video-container').addClass(this.VU);
            this._createVideoContainer(videoData, $image);
            this._setVideoEvent($image, this.PV, fotorama, number);
        },
        _prepareForImage3DContainer: function ($image, videoData, fotorama, number) {
            $image.addClass('fotorama-image3D-container').addClass("kvadro");
            this._create3DContainer(videoData, $image);
            console.log(this.PV);
            this._setVideoEvent($image, this.PV, fotorama, number);
        },
        /**
         * Create video container
         *
         * @param {Object} videoData
         * @param {jQuery} $image
         * @private
         */
        _createVideoContainer: function (videoData, $image) {
            var videoSettings;

            videoSettings = this.options.videoSettings[0];
            $image.find('.' + this.PV).remove();
            $image.append(
                '<div class="' +
                this.PV +
                '" data-related="' +
                videoSettings.showRelated +
                '" data-loop="' +
                videoSettings.videoAutoRestart +
                '" data-type="' +
                videoData.provider +
                '" data-code="' +
                videoData.id +
                '"  data-youtubenocookie="' +
                videoData.useYoutubeNocookie +
               '" data-width="100%" data-height="100%"></div>'
            );
        },
        _create3DContainer: function (videoData, $image) {
            console.log('_create3DContainer');
            console.log(videoData);
            console.log($image);
            console.log($image.children());
            $image.find('.' + this.PV).remove();


            var iframe3D ="<iframe width='100%'"+
            "height='600px'" +
            "frameborder='0'" +
            "allowfullscreen" +
            "mozallowfullscreen='true'" +
            "webkitallowfullscreen='true'" +
            "style='border:0;'"+
            "src='https://api.kvadro.com/api/player/c2fc7a9c-dd5c-4367-b82c-87ad82dde1d9\/embedded" +
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
            $image.html($(iframe3D));
        },

        /**
         *
         * @param {Object} $image
         * @param {Object} PV
         * @param {Object} fotorama
         * @param {Number} number
         * @private
         */
        _setVideoEvent: function ($image, PV, fotorama, number) {
            $image.find('.magnify-lens').remove();
            $image
                .off('click tap', $.proxy(this._clickHandler, this))
                .on('click tap', $.proxy(this._clickHandler, this));
            this._handleBaseVideo(fotorama, number); //check for video is it base and handle it if it's base
        },

        /**
         * Hides preview arrows above video player.
         * @private
         */
        _hideVideoArrows: function () {
            var arrows = $('.' + this.FTAR);

            arrows.removeClass('fotorama__arr--shown');
            arrows.removeClass('fotorama__arr--hidden');
        },

        /**
         * @private
         */
        _showLoader: function () {
            var spinner = this.fotoramaItem.find('.' + this.fotoramaSpinner);

            spinner.addClass(this.fotoramaSpinnerShow);
            this.fotoramaItem.data('fotorama').activeFrame.$stageFrame.addClass(this.PVLOADING);
        },

        /**
         * @private
         */
        _hideLoader: function () {
            var spinner = this.fotoramaItem.find('.' + this.fotoramaSpinner);

            spinner.removeClass(this.fotoramaSpinnerShow);
            this.fotoramaItem.data('fotorama').activeFrame.$stageFrame.removeClass(this.PVLOADING);
        },

        /**
         * @param {Event} event
         * @private
         */
        _clickHandler: function (event) {
            var type;

            if ($(event.target).hasClass(this.VU) && $(event.target).find('iframe').length === 0) {
                $(event.target).removeClass(this.VU);
                type = $(event.target).find('.' + this.PV).data('type');

                if (this.vimeoJSFrameworkLoaded && type === this.VI) {
                    $(event.target).find('.' + this.PV).productVideoLoader();
                } else if (type === this.VI) {
                    this._showLoader();
                    this.onVimeoJSFramework = function () {
                        $(event.target).find('.' + this.PV).productVideoLoader();
                        this._hideLoader();
                    }.bind(this);
                } else {
                    $(event.target).find('.' + this.PV).productVideoLoader();
                }

                $('.' + this.FTAR).addClass(this.isFullscreen ? 'fotorama__arr--shown' : 'fotorama__arr--hidden');
            }
        },

        /**
         * Handle base video
         * @param {Object} fotorama
         * @param {Number} srcNumber
         * @private
         */
        _handleBaseVideo: function (fotorama, srcNumber) {
            var waitForFroogaloop,
                videoData = this.options.videoData,
                activeIndex = fotorama.activeIndex,
                number = parseInt(srcNumber, 10),
                activeIndexIsBase = videoData[activeIndex];

            if (!this.Base) {
                return;
            }

            if (activeIndexIsBase && number === 1 && $(window).width() > this.MobileMaxWidth) {
                if (this.options.videoData[fotorama.activeIndex].provider === this.VI) {
                    waitForFroogaloop = setInterval($.proxy(function () {
                        if (window.Froogaloop) {
                            clearInterval(waitForFroogaloop);
                            fotorama.requestFullScreen();
                            this.fotoramaItem.data('fotorama').activeFrame.$stageFrame[0].click();
                            this.Base = false;
                        }
                    }, this), 50);
                } else { //if not a vimeo - play it immediately with a little lag in case for fotorama fullscreen
                    setTimeout($.proxy(function () {
                        fotorama.requestFullScreen();
                        this.fotoramaItem.data('fotorama').activeFrame.$stageFrame[0].click();
                        this.Base = false;
                    }, this), 50);
                }
            }
        },

        /**
         * Destroy video player
         * @param {jQuery} $wrapper
         * @param {jQuery} current
         * @param {bool} close
         * @private
         */
        _unloadVideoPlayer: function ($wrapper, current, close) {
            var self = this;

            if (!$wrapper) {
                return;
            }

            $wrapper.find('.' + this.PVLOADED).removeClass(this.PVLOADED);
            this._hideLoader();

            $wrapper.find('.' + this.PV).each(function () {
                var $item = $(this).parent(),
                    cloneVideoDiv,
                    iframeElement = $(this).find('iframe'),
                    currentIndex,
                    itemIndex;

                if (iframeElement.length === 0) {
                    return;
                }

                currentIndex = current.activeFrame.$stageFrame.index();
                itemIndex = $item.index();

                if (currentIndex === itemIndex && !close) {
                    return;
                }

                if (currentIndex !== itemIndex && close) {
                    return;
                }

                iframeElement.remove();
                cloneVideoDiv = $(this).clone();
                $(this).remove();
                $item.append(cloneVideoDiv);
                $item.addClass(self.VU);

                self._hideCloseVideo();
                self._hideVideoArrows();

                if (self.isFullscreen && !self.fotoramaItem.data('fotorama').options.fullscreen.arrows) {
                    if ($('.' + self.FTAR + '--prev').is(':focus') || $('.' + self.FTAR + '--next').is(':focus')) {
                        $(self.FTCF).focus();
                    }
                }
            });
        }
    });

    return $.mage.AddFotoramaImage3DEvents1;
});
