<script src="https://cdn.webrtc-experiment.com/RecordRTC.js"></script>

<!-- for Edge/FF/Chrome/Opera/etc. getUserMedia support -->
<script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
<script src="https://cdn.webrtc-experiment.com/DetectRTC.js"> </script>

<!-- video element -->
<link href="https://cdn.webrtc-experiment.com/getHTMLMediaElement.css" rel="stylesheet">
<script src="https://cdn.webrtc-experiment.com/getHTMLMediaElement.js"></script>
<style type="text/css">
    .recordrtc{
        padding: 20px 0;
    }
    footer{
        z-index: 10;
    }
    #question_input{
        text-align: center;
    }
    .media-container{
        width: 100% !important;
    }
    .media-controls{
        right: 22px;
        margin-left: 0;
        margin-top: 10px;
        z-index: 9;
        display: none;
    }
    .media-box video{
        max-height: 100% !important;
    }
</style>

<section class="experiment recordrtc">
    <div id="success_upload" style="display: none; width: 100%;overflow: hidden;"> <strong>Success: </strong> Your video saved successfully! </div>
    <div id="uploading_msg" style="display: none; width: 100%;overflow: hidden;"> <strong>Please wait: </strong> Uploading your video .. </div>
    <div id="videoTime" style="float: left;width: 50%;margin-bottom: 5px;"></div>
    <div style="display: none;">
        <select class="recording-media">
            <option value="record-audio-plus-video">Microphone+Camera</option>
        </select>
        <select class="media-container-format">
            <option>default</option>
        </select>
        <button id="btn-pause-recording">Pause</button>
        <select class="media-resolutions">
            <option value="640x480">480p</option>
        </select>

        <select class="media-framerates">
            <option value="default">Default framerates</option>
        </select>

        <select class="media-bitrates">
            <option value="default">Default bitrates</option>
        </select>
    </div>

    <div style="text-align: right;">
        <button id="upload-to-server" class="btn btn-success" style="margin-top: -10px;display: none;">Save my record</button>
    </div>

    <div style="margin-top: 10px;" id="recording-player"></div>
</section>

<script>
    (function() {
        var params = {},
            r = /([^&=]+)=?([^&]*)/g;

        function d(s) {
            return decodeURIComponent(s.replace(/\+/g, ' '));
        }

        var match, search = window.location.search;
        while (match = r.exec(search.substring(1))) {
            params[d(match[1])] = d(match[2]);

            if(d(match[2]) === 'true' || d(match[2]) === 'false') {
                params[d(match[1])] = d(match[2]) === 'true' ? true : false;
            }
        }

        window.params = params;
    })();

    function addStreamStopListener(stream, callback) {
        var streamEndedEvent = 'ended';

        if ('oninactive' in stream) {
            streamEndedEvent = 'inactive';
        }

        stream.addEventListener(streamEndedEvent, function() {
            callback();
            callback = function() {};
        }, false);

        stream.getAudioTracks().forEach(function(track) {
            track.addEventListener(streamEndedEvent, function() {
                callback();
                callback = function() {};
            }, false);
        });

        stream.getVideoTracks().forEach(function(track) {
            track.addEventListener(streamEndedEvent, function() {
                callback();
                callback = function() {};
            }, false);
        });
    }


    var video = document.createElement('video');
    video.id = 'recordVideo';
    video.controls = false;

    var mediaElement = getHTMLMediaElement(video, {
        title: 'Recording status: inactive <br>',
        buttons: ['take-snapshot'],
        showOnMouseEnter: false,
        width: 360,
        onTakeSnapshot: function() {
            var canvas = document.createElement('canvas');
            canvas.width = mediaElement.clientWidth;
            canvas.height = mediaElement.clientHeight;

            var context = canvas.getContext('2d');
            context.drawImage(recordingPlayer, 0, 0, canvas.width, canvas.height);
            imageBlob = canvas.toDataURL('image/png');
        }
    });
    

    document.getElementById('recording-player').appendChild(mediaElement);
    var div = document.createElement('section');
    mediaElement.media.parentNode.appendChild(div);
    div.appendChild(mediaElement.media);

    var lookId = '';
    var imageBlob = '';
    var video_id = document.getElementById('video_id').value;
    var recordingPlayer = mediaElement.media;
    var recordingMedia = document.querySelector('.recording-media');
    var mediaContainerFormat = document.querySelector('.media-container-format');
    var mimeType = 'video/webm';
    var fileExtension = 'webm';
    var type = 'video';
    var recorderType;
    var defaultWidth;
    var defaultHeight;

    var btnStartRecording = document.querySelector('#start_recording');

    window.onbeforeunload = function() {
        btnStartRecording.disabled = false;
        recordingMedia.disabled = false;
        mediaContainerFormat.disabled = false;
    };

    btnStartRecording.onclick = function(event) {
        var button = btnStartRecording;
        $('#success_upload', "#uploading_msg").hide();

        if(button.innerHTML === 'Start' || button.innerHTML === 'Re-Record') {
            $('#upload-to-server').hide();
            if( !$("#question").val() ) {

                $( "#no-question" ).show( "fast", function() { });
                return false;

            } else {
                $('.media-box h2').text('Recording status: active');
                $( "#no-question" ).hide( "slow", function() { });

            }
        }

        if(button.innerHTML === 'Stop') {
            $('.media-box h2').text('Recording status: inactive');
            $('#upload-to-server').show();
            $('.media-controls').hide()

            var canvas = document.createElement('canvas');
            canvas.width = mediaElement.clientWidth;
            canvas.height = mediaElement.clientHeight;

            var context = canvas.getContext('2d');
            context.drawImage(recordingPlayer, 0, 0, canvas.width, canvas.height);
            imageBlob = canvas.toDataURL('image/png');

            button.disabled = true;
            button.disableStateWaiting = true;
            setTimeout(function() {
                button.disabled = false;
                button.disableStateWaiting = false;
            }, 2000);

            button.innerHTML = 'Re-Record';

            function stopStream() {
                if(button.stream && button.stream.stop) {
                    button.stream.stop();
                    button.stream = null;
                }

                if(button.stream instanceof Array) {
                    button.stream.forEach(function(stream) {
                        stream.stop();
                    });
                    button.stream = null;
                }

                videoBitsPerSecond = null;
                var html = 'Recording status: stopped';
                html += '<br>Size: ' + bytesToSize(button.recordRTC.getBlob().size);
                recordingPlayer.parentNode.parentNode.querySelector('h2').innerHTML = html;
            }

            if(button.recordRTC) {
                if(button.recordRTC.length) {
                    button.recordRTC[0].stopRecording(function(url) {
                        if(!button.recordRTC[1]) {
                            button.recordingEndedCallback(url);
                            stopStream();

                            saveToDiskOrOpenNewTab(button.recordRTC[0]);
                            return;
                        }

                        button.recordRTC[1].stopRecording(function(url) {
                            button.recordingEndedCallback(url);
                            stopStream();
                        });
                    });
                }
                else {
                    button.recordRTC.stopRecording(function(url) {
                        if(button.blobs && button.blobs.length) {
                            var blob = new File(button.blobs, getFileName(fileExtension), {
                                type: mimeType
                            });
                            
                            button.recordRTC.getBlob = function() {
                                return blob;
                            };

                            url = URL.createObjectURL(blob);
                        }

                        button.recordingEndedCallback(url);
                        saveToDiskOrOpenNewTab(button.recordRTC);
                        stopStream();
                    });
                }
            }

            return;
        }

        if(!event) return;

        button.disabled = true;

        var commonConfig = {
            onMediaCaptured: function(stream) {
                button.stream = stream;
                if(button.mediaCapturedCallback) {
                    button.mediaCapturedCallback();
                }

                button.innerHTML = 'Stop';
                button.disabled = false;
            },
            onMediaStopped: function() {
                button.innerHTML = 'Re-Record';

                if(!button.disableStateWaiting) {
                    button.disabled = false;
                }
            },
            onMediaCapturingFailed: function(error) {
                console.error('onMediaCapturingFailed:', error);

                if(error.toString().indexOf('no audio or video tracks available') !== -1) {
                    alert('RecordRTC failed to start because there are no audio or video tracks available.');
                }

                if(DetectRTC.browser.name === 'Safari') return;
                
                if(error.name === 'PermissionDeniedError' && DetectRTC.browser.name === 'Firefox') {
                    alert('Firefox requires version >= 52. Firefox also requires HTTPs.');
                }

                commonConfig.onMediaStopped();
            }
        };

        if(mediaContainerFormat.value === 'h264') {
            mimeType = 'video/webm\;codecs=h264';
            fileExtension = 'mp4';

            // video/mp4;codecs=avc1    
            if(isMimeTypeSupported('video/mpeg')) {
                mimeType = 'video/mpeg';
            }
        }

        if(mediaContainerFormat.value === 'mkv' && isMimeTypeSupported('video/x-matroska;codecs=avc1')) {
            mimeType = 'video/x-matroska;codecs=avc1';
            fileExtension = 'mkv';
        }

        if(mediaContainerFormat.value === 'vp8' && isMimeTypeSupported('video/webm\;codecs=vp8')) {
            mimeType = 'video/webm\;codecs=vp8';
            fileExtension = 'webm';
            recorderType = null;
            type = 'video';
        }

        if(mediaContainerFormat.value === 'vp9' && isMimeTypeSupported('video/webm\;codecs=vp9')) {
            mimeType = 'video/webm\;codecs=vp9';
            fileExtension = 'webm';
            recorderType = null;
            type = 'video';
        }

        if(mediaContainerFormat.value === 'pcm') {
            mimeType = 'audio/wav';
            fileExtension = 'wav';
            recorderType = StereoAudioRecorder;
            type = 'audio';
        }

        if(mediaContainerFormat.value === 'opus' || mediaContainerFormat.value === 'ogg') {
            if(isMimeTypeSupported('audio/webm')) {
                mimeType = 'audio/webm';
                fileExtension = 'webm'; // webm
            }

            if(isMimeTypeSupported('audio/ogg')) {
                mimeType = 'audio/ogg; codecs=opus';
                fileExtension = 'ogg'; // ogg
            }

            recorderType = null;
            type = 'audio';
        }

        if(mediaContainerFormat.value === 'whammy') {
            mimeType = 'video/webm';
            fileExtension = 'webm';
            recorderType = WhammyRecorder;
            type = 'video';
        }

        if(mediaContainerFormat.value === 'gif') {
            mimeType = 'image/gif';
            fileExtension = 'gif';
            recorderType = GifRecorder;
            type = 'gif';
        }

        if(mediaContainerFormat.value === 'default') {
            mimeType = 'video/webm';
            fileExtension = 'webm';
            recorderType = null;
            type = 'video';
        }

        if(recordingMedia.value === 'record-audio') {
            captureAudio(commonConfig);

            button.mediaCapturedCallback = function() {
                var options = {
                    type: type,
                    mimeType: mimeType,
                    leftChannel: params.leftChannel || false,
                    disableLogs: params.disableLogs || false
                };

                if(params.sampleRate) {
                    options.sampleRate = parseInt(params.sampleRate);
                }

                if(params.bufferSize) {
                    options.bufferSize = parseInt(params.bufferSize);
                }

                if(recorderType) {
                    options.recorderType = recorderType;
                }

                if(videoBitsPerSecond) {
                    options.videoBitsPerSecond = videoBitsPerSecond;
                }

                if(DetectRTC.browser.name === 'Edge') {
                    options.numberOfAudioChannels = 1;
                }

                options.ignoreMutedMedia = false;
                button.recordRTC = RecordRTC(button.stream, options);

                button.recordingEndedCallback = function(url) {
                    setVideoURL(url);
                };

                button.recordRTC.startRecording();
            };
        }

        if(recordingMedia.value === 'record-audio-plus-video') {
            captureAudioPlusVideo(commonConfig);

            button.mediaCapturedCallback = function() {
                if(typeof MediaRecorder === 'undefined') { // opera or chrome etc.
                    button.recordRTC = [];

                    if(!params.bufferSize) {
                        // it fixes audio issues whilst recording 720p
                        params.bufferSize = 16384;
                    }

                    var options = {
                        type: 'audio', // hard-code to set "audio"
                        leftChannel: params.leftChannel || false,
                        disableLogs: params.disableLogs || false,
                        video: recordingPlayer
                    };

                    if(params.sampleRate) {
                        options.sampleRate = parseInt(params.sampleRate);
                    }

                    if(params.bufferSize) {
                        options.bufferSize = parseInt(params.bufferSize);
                    }

                    if(params.frameInterval) {
                        options.frameInterval = parseInt(params.frameInterval);
                    }

                    if(recorderType) {
                        options.recorderType = recorderType;
                    }

                    if(videoBitsPerSecond) {
                        options.videoBitsPerSecond = videoBitsPerSecond;
                    }

                    options.ignoreMutedMedia = false;
                    var audioRecorder = RecordRTC(button.stream, options);

                    options.type = type;
                    var videoRecorder = RecordRTC(button.stream, options);

                    // to sync audio/video playbacks in browser!
                    videoRecorder.initRecorder(function() {
                        audioRecorder.initRecorder(function() {
                            audioRecorder.startRecording();
                            videoRecorder.startRecording();
                        });
                    });

                    button.recordRTC.push(audioRecorder, videoRecorder);

                    button.recordingEndedCallback = function() {
                        var audio = new Audio();
                        audio.src = audioRecorder.toURL();
                        audio.controls = true;
                        audio.autoplay = true;

                        recordingPlayer.parentNode.appendChild(document.createElement('hr'));
                        recordingPlayer.parentNode.appendChild(audio);

                        if(audio.paused) audio.play();
                    };
                    return;
                }

                var options = {
                    type: type,
                    mimeType: mimeType,
                    disableLogs: params.disableLogs || false,
                    getNativeBlob: false, // enable it for longer recordings
                    video: recordingPlayer
                };

                if(recorderType) {
                    options.recorderType = recorderType;

                    if(recorderType == WhammyRecorder || recorderType == GifRecorder) {
                        options.canvas = options.video = {
                            width: defaultWidth || 320,
                            height: defaultHeight || 240
                        };
                    }
                }

                if(videoBitsPerSecond) {
                    options.videoBitsPerSecond = videoBitsPerSecond;
                }

                options.ignoreMutedMedia = false;
                button.recordRTC = RecordRTC(button.stream, options);

                button.recordingEndedCallback = function(url) {
                    setVideoURL(url);
                };

                button.recordRTC.startRecording();
                recordingPlayer.parentNode.parentNode.querySelector('h2').innerHTML = '<img src="https://cdn.webrtc-experiment.com/images/progress.gif">';
                $('.media-controls').show();
                var duration = 0;
                setInterval(function() {
                    if( button.innerHTML === 'Stop' ) {
                        duration++;
                    }

                  $('#videoTime').text( duration.toString().toHHMMSS() )

                }, 1000);
            };
        }

        if(recordingMedia.value === 'record-screen') {
            captureScreen(commonConfig);

            button.mediaCapturedCallback = function() {
                var options = {
                    type: type,
                    mimeType: mimeType,
                    disableLogs: params.disableLogs || false,
                    getNativeBlob: false, // enable it for longer recordings
                    video: recordingPlayer
                };

                if(recorderType) {
                    options.recorderType = recorderType;

                    if(recorderType == WhammyRecorder || recorderType == GifRecorder) {
                        options.canvas = options.video = {
                            width: defaultWidth || 320,
                            height: defaultHeight || 240
                        };
                    }
                }

                if(videoBitsPerSecond) {
                    options.videoBitsPerSecond = videoBitsPerSecond;
                }

                options.ignoreMutedMedia = false;
                button.recordRTC = RecordRTC(button.stream, options);

                button.recordingEndedCallback = function(url) {
                    setVideoURL(url);
                };

                button.recordRTC.startRecording();
            };
        }

        // note: audio+tab is supported in Chrome 50+
        // todo: add audio+tab recording
        if(recordingMedia.value === 'record-audio-plus-screen') {
            captureAudioPlusScreen(commonConfig);

            button.mediaCapturedCallback = function() {
                var options = {
                    type: type,
                    mimeType: mimeType,
                    disableLogs: params.disableLogs || false,
                    getNativeBlob: false, // enable it for longer recordings
                    video: recordingPlayer
                };

                if(recorderType) {
                    options.recorderType = recorderType;

                    if(recorderType == WhammyRecorder || recorderType == GifRecorder) {
                        options.canvas = options.video = {
                            width: defaultWidth || 320,
                            height: defaultHeight || 240
                        };
                    }
                }

                if(videoBitsPerSecond) {
                    options.videoBitsPerSecond = videoBitsPerSecond;
                }

                options.ignoreMutedMedia = false;
                button.recordRTC = RecordRTC(button.stream, options);

                button.recordingEndedCallback = function(url) {
                    setVideoURL(url);
                };

                button.recordRTC.startRecording();
            };
        }
    };

    function captureVideo(config) {
        captureUserMedia({video: true}, function(videoStream) {
            config.onMediaCaptured(videoStream);

            addStreamStopListener(videoStream, function() {
                config.onMediaStopped();
            });
        }, function(error) {
            config.onMediaCapturingFailed(error);
        });
    }

    function captureAudio(config) {
        captureUserMedia({audio: true}, function(audioStream) {
            config.onMediaCaptured(audioStream);

            addStreamStopListener(audioStream, function() {
                config.onMediaStopped();
            });
        }, function(error) {
            config.onMediaCapturingFailed(error);
        });
    }

    function captureAudioPlusVideo(config) {
        captureUserMedia({video: true, audio: true}, function(audioVideoStream) {
            config.onMediaCaptured(audioVideoStream);

            if(audioVideoStream instanceof Array) {
                audioVideoStream.forEach(function(stream) {
                    addStreamStopListener(stream, function() {
                        config.onMediaStopped();
                    });
                });
                return;
            }

            addStreamStopListener(audioVideoStream, function() {
                config.onMediaStopped();
            });
        }, function(error) {
            config.onMediaCapturingFailed(error);
        });
    }

    var MY_DOMAIN = 'webrtc-experiment.com';

    function isMyOwnDomain() {
        // replace "webrtc-experiment.com" with your own domain name
        return document.domain.indexOf(MY_DOMAIN) !== -1;
    }

    function isLocalHost() {
        // "chrome.exe" --enable-usermedia-screen-capturing
        // or firefox => about:config => "media.getusermedia.screensharing.allowed_domains" => add "localhost"
        return document.domain === 'localhost' || document.domain === '127.0.0.1';
    }

    function captureScreen(config) {
        // Firefox screen capturing addon is open-sourced here: https://github.com/muaz-khan/Firefox-Extensions
        // Google Chrome screen capturing extension is open-sourced here: https://github.com/muaz-khan/Chrome-Extensions/tree/master/desktopCapture

        window.getScreenId = function(chromeMediaSource, chromeMediaSourceId) {
            var screenConstraints = {
                audio: false,
                video: {
                    mandatory: {
                        chromeMediaSourceId: chromeMediaSourceId,
                        chromeMediaSource: isLocalHost() ? 'screen' : chromeMediaSource
                    }
                }
            };

            if(DetectRTC.browser.name === 'Firefox') {
                screenConstraints = {
                    video: {
                        mediaSource: 'window'
                    }
                }
            }

            captureUserMedia(screenConstraints, function(screenStream) {
                config.onMediaCaptured(screenStream);

                addStreamStopListener(screenStream, function() {
                    // config.onMediaStopped();

                    btnStartRecording.onclick();
                });
            }, function(error) {
                config.onMediaCapturingFailed(error);

                if(isMyOwnDomain() === false && DetectRTC.browser.name === 'Chrome') {
                    // otherwise deploy chrome extension yourselves
                    // https://github.com/muaz-khan/Chrome-Extensions/tree/master/desktopCapture
                    alert('Please enable this command line flag: "--enable-usermedia-screen-capturing"');
                }

                if(isMyOwnDomain() === false && DetectRTC.browser.name === 'Firefox') {
                    // otherwise deploy firefox addon yourself
                    // https://github.com/muaz-khan/Firefox-Extensions
                    alert('Please enable screen capturing for your domain. Open "about:config" and search for "media.getusermedia.screensharing.allowed_domains"');
                }
            });
        };

        if(DetectRTC.browser.name === 'Firefox' || isLocalHost()) {
            window.getScreenId();
        }

        window.postMessage('get-sourceId', '*');
    }

    function captureAudioPlusScreen(config) {
        // Firefox screen capturing addon is open-sourced here: https://github.com/muaz-khan/Firefox-Extensions
        // Google Chrome screen capturing extension is open-sourced here: https://github.com/muaz-khan/Chrome-Extensions/tree/master/desktopCapture

        window.getScreenId = function(chromeMediaSource, chromeMediaSourceId) {
            var screenConstraints = {
                audio: false,
                video: {
                    mandatory: {
                        chromeMediaSourceId: chromeMediaSourceId,
                        chromeMediaSource: isLocalHost() ? 'screen' : chromeMediaSource
                    }
                }
            };

            if(DetectRTC.browser.name === 'Firefox') {
                screenConstraints = {
                    video: {
                        mediaSource: 'window'
                    },
                    audio: false
                }
            }

            captureUserMedia(screenConstraints, function(screenStream) {
                captureUserMedia({audio: true}, function(audioStream) {
                    var newStream = new MediaStream();

                    // merge audio and video tracks in a single stream
                    audioStream.getAudioTracks().forEach(function(track) {
                        newStream.addTrack(track);
                    });

                    screenStream.getVideoTracks().forEach(function(track) {
                        newStream.addTrack(track);
                    });

                    config.onMediaCaptured(newStream);

                    addStreamStopListener(newStream, function() {
                        config.onMediaStopped();
                    });
                }, function(error) {
                    config.onMediaCapturingFailed(error);
                });
            }, function(error) {
                config.onMediaCapturingFailed(error);

                if(isMyOwnDomain() === false && DetectRTC.browser.name === 'Chrome') {
                    // otherwise deploy chrome extension yourselves
                    // https://github.com/muaz-khan/Chrome-Extensions/tree/master/desktopCapture
                    alert('Please enable this command line flag: "--enable-usermedia-screen-capturing"');
                }

                if(isMyOwnDomain() === false && DetectRTC.browser.name === 'Firefox') {
                    // otherwise deploy firefox addon yourself
                    // https://github.com/muaz-khan/Firefox-Extensions
                    alert('Please enable screen capturing for your domain. Open "about:config" and search for "media.getusermedia.screensharing.allowed_domains"');
                }
            });
        };

        if(DetectRTC.browser.name === 'Firefox' || isLocalHost()) {
            window.getScreenId();
        }

        window.postMessage('get-sourceId', '*');
    }

    var videoBitsPerSecond;

    function setVideoBitrates() {
        var select = document.querySelector('.media-bitrates');
        var value = select.value;

        if(value == 'default') {
            videoBitsPerSecond = null;
            return;
        }

        videoBitsPerSecond = parseInt(value);
    }

    function getFrameRates(mediaConstraints) {
        if(!mediaConstraints.video) {
            return mediaConstraints;
        }

        var select = document.querySelector('.media-framerates');
        var value = select.value;

        if(value == 'default') {
            return mediaConstraints;
        }

        value = parseInt(value);

        if(DetectRTC.browser.name === 'Firefox') {
            mediaConstraints.video.frameRate = value;
            return mediaConstraints;
        }

        if(!mediaConstraints.video.mandatory) {
            mediaConstraints.video.mandatory = {};
            mediaConstraints.video.optional = [];
        }

        var isScreen = recordingMedia.value.toString().toLowerCase().indexOf('screen') != -1;
        if(isScreen) {
            mediaConstraints.video.mandatory.maxFrameRate = value;
        }
        else {
            mediaConstraints.video.mandatory.minFrameRate = value;
        }

        return mediaConstraints;
    }

    function setGetFromLocalStorage(selectors) {
        selectors.forEach(function(selector) {
            var storageItem = selector.replace(/\.|#/g, '');
            if(localStorage.getItem(storageItem)) {
                document.querySelector(selector).value = localStorage.getItem(storageItem);
            }

            addEventListenerToUploadLocalStorageItem(selector, ['change', 'blur'], function() {
                localStorage.setItem(storageItem, document.querySelector(selector).value);
            });
        });
    }

    function addEventListenerToUploadLocalStorageItem(selector, arr, callback) {
        arr.forEach(function(event) {
            document.querySelector(selector).addEventListener(event, callback, false);
        });
    }

    setGetFromLocalStorage(['.media-resolutions', '.media-framerates', '.media-bitrates', '.recording-media', '.media-container-format']);

    function getVideoResolutions(mediaConstraints) {
        if(!mediaConstraints.video) {
            return mediaConstraints;
        }

        var select = document.querySelector('.media-resolutions');
        var value = select.value;

        if(value == 'default') {
            return mediaConstraints;
        }

        value = value.split('x');

        if(value.length != 2) {
            return mediaConstraints;
        }

        defaultWidth = parseInt(value[0]);
        defaultHeight = parseInt(value[1]);

        if(DetectRTC.browser.name === 'Firefox') {
            mediaConstraints.video.width = defaultWidth;
            mediaConstraints.video.height = defaultHeight;
            return mediaConstraints;
        }

        if(!mediaConstraints.video.mandatory) {
            mediaConstraints.video.mandatory = {};
            mediaConstraints.video.optional = [];
        }

        var isScreen = recordingMedia.value.toString().toLowerCase().indexOf('screen') != -1;

        if(isScreen) {
            mediaConstraints.video.mandatory.maxWidth = defaultWidth;
            mediaConstraints.video.mandatory.maxHeight = defaultHeight;
        }
        else {
            mediaConstraints.video.mandatory.minWidth = defaultWidth;
            mediaConstraints.video.mandatory.minHeight = defaultHeight;
        }

        return mediaConstraints;
    }

    function captureUserMedia(mediaConstraints, successCallback, errorCallback) {
        if(mediaConstraints.video == true) {
            mediaConstraints.video = {};
        }

        setVideoBitrates();

        mediaConstraints = getVideoResolutions(mediaConstraints);
        mediaConstraints = getFrameRates(mediaConstraints);

        var isBlackBerry = !!(/BB10|BlackBerry/i.test(navigator.userAgent || ''));
        if(isBlackBerry && !!(navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia)) {
            navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
            navigator.getUserMedia(mediaConstraints, successCallback, errorCallback);
            return;
        }

        navigator.mediaDevices.getUserMedia(mediaConstraints).then(function(stream) {
            successCallback(stream);

            setVideoURL(stream, true);
        }).catch(function(error) {
            if(error && error.name === 'ConstraintNotSatisfiedError') {
                alert('Your camera or browser does NOT supports selected resolutions or frame-rates. \n\nPlease select "default" resolutions.');
            }

            errorCallback(error);
        });
    }

    function setMediaContainerFormat(arrayOfOptionsSupported) {
        var options = Array.prototype.slice.call(
            mediaContainerFormat.querySelectorAll('option')
        );

        var localStorageItem;
        if(localStorage.getItem('media-container-format')) {
            localStorageItem = localStorage.getItem('media-container-format');
        }

        var selectedItem;
        options.forEach(function(option) {
            option.disabled = true;

            if(arrayOfOptionsSupported.indexOf(option.value) !== -1) {
                option.disabled = false;

                if(localStorageItem && arrayOfOptionsSupported.indexOf(localStorageItem) != -1) {
                    if(option.value != localStorageItem) return;
                    option.selected = true;
                    selectedItem = option;
                    return;
                }

                if(!selectedItem) {
                    option.selected = true;
                    selectedItem = option;
                }
            }
        });
    }

    function isMimeTypeSupported(mimeType) {
        if(DetectRTC.browser.name === 'Edge' || DetectRTC.browser.name === 'Safari' || typeof MediaRecorder === 'undefined') {
            return false;
        }

        if(typeof MediaRecorder.isTypeSupported !== 'function') {
            return true;
        }

        return MediaRecorder.isTypeSupported(mimeType);
    }

    recordingMedia.onchange = function() {
        if(recordingMedia.value === 'record-audio') {
            var recordingOptions = [];
            
            if(isMimeTypeSupported('audio/webm')) {
                recordingOptions.push('opus');
            }

            if(isMimeTypeSupported('audio/ogg')) {
                recordingOptions.push('ogg');
            }

            recordingOptions.push('pcm');

            setMediaContainerFormat(recordingOptions);
            return;
        }

        var isChrome = !!window.chrome && !(!!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0);

        var recordingOptions = ['vp8']; // MediaStreamRecorder with vp8

        if(isMimeTypeSupported('video/webm\;codecs=vp9')) {
            recordingOptions.push('vp9'); // MediaStreamRecorder with vp9
        }

        if(isMimeTypeSupported('video/webm\;codecs=h264')) {
            recordingOptions.push('h264'); // MediaStreamRecorder with h264
        }

        if(isMimeTypeSupported('video/x-matroska;codecs=avc1')) {
            recordingOptions.push('mkv'); // MediaStreamRecorder with mkv/matroska
        }

        recordingOptions.push('gif'); // GifRecorder

        if(isChrome) {
            recordingOptions.push('whammy'); // WhammyRecorder
        }

        recordingOptions.push('default'); // Default mimeType for MediaStreamRecorder

        setMediaContainerFormat(recordingOptions);
    };
    recordingMedia.onchange();

    if(DetectRTC.browser.name === 'Edge' || DetectRTC.browser.name === 'Safari') {
        // webp isn't supported in Microsoft Edge
        // neither MediaRecorder API
        // so lets disable both video/screen recording options

        console.warn('Neither MediaRecorder API nor webp is supported in ' + DetectRTC.browser.name + '. You cam merely record audio.');

        recordingMedia.innerHTML = '<option value="record-audio">Audio</option>';
        setMediaContainerFormat(['pcm']);
    }

    function stringify(obj) {
        var result = '';
        Object.keys(obj).forEach(function(key) {
            if(typeof obj[key] === 'function') {
                return;
            }

            if(result.length) {
                result += ',';
            }

            result += key + ': ' + obj[key];
        });

        return result;
    }

    function mediaRecorderToStringify(mediaRecorder) {
        var result = '';
        result += 'mimeType: ' + mediaRecorder.mimeType;
        result += ', state: ' + mediaRecorder.state;
        result += ', audioBitsPerSecond: ' + mediaRecorder.audioBitsPerSecond;
        result += ', videoBitsPerSecond: ' + mediaRecorder.videoBitsPerSecond;
        if(mediaRecorder.stream) {
            result += ', streamid: ' + mediaRecorder.stream.id;
            result += ', stream-active: ' + mediaRecorder.stream.active;
        }
        return result;
    }

    function getFailureReport() {
        var info = 'RecordRTC seems failed. \n\n' + stringify(DetectRTC.browser) + '\n\n' + DetectRTC.osName + ' ' + DetectRTC.osVersion + '\n';

        if (typeof recorderType !== 'undefined' && recorderType) {
            info += '\nrecorderType: ' + recorderType.name;
        }

        if (typeof mimeType !== 'undefined') {
            info += '\nmimeType: ' + mimeType;
        }

        Array.prototype.slice.call(document.querySelectorAll('select')).forEach(function(select) {
            info += '\n' + (select.id || select.className) + ': ' + select.value;
        });

        if (btnStartRecording.recordRTC) {
            info += '\n\ninternal-recorder: ' + btnStartRecording.recordRTC.getInternalRecorder().name;
            
            if(btnStartRecording.recordRTC.getInternalRecorder().getAllStates) {
                info += '\n\nrecorder-states: ' + btnStartRecording.recordRTC.getInternalRecorder().getAllStates();
            }
        }

        if(btnStartRecording.stream) {
            info += '\n\naudio-tracks: ' + btnStartRecording.stream.getAudioTracks().length;
            info += '\nvideo-tracks: ' + btnStartRecording.stream.getVideoTracks().length;
            info += '\nstream-active? ' + !!btnStartRecording.stream.active;

            btnStartRecording.stream.getAudioTracks().concat(btnStartRecording.stream.getVideoTracks()).forEach(function(track) {
                info += '\n' + track.kind + '-track-' + (track.label || track.id) + ': (enabled: ' + !!track.enabled + ', readyState: ' + track.readyState + ', muted: ' + !!track.muted + ')';

                if(track.getConstraints && Object.keys(track.getConstraints()).length) {
                    info += '\n' + track.kind + '-track-getConstraints: ' + stringify(track.getConstraints());
                }

                if(track.getSettings && Object.keys(track.getSettings()).length) {
                    info += '\n' + track.kind + '-track-getSettings: ' + stringify(track.getSettings());
                }
            });
        }


        else if(btnStartRecording.recordRTC && btnStartRecording.recordRTC.getBlob()) {
            info += '\n\nblobSize: ' + bytesToSize(btnStartRecording.recordRTC.getBlob().size);
        }

        if(btnStartRecording.recordRTC && btnStartRecording.recordRTC.getInternalRecorder() && btnStartRecording.recordRTC.getInternalRecorder().getInternalRecorder && btnStartRecording.recordRTC.getInternalRecorder().getInternalRecorder()) {
            info += '\n\ngetInternalRecorder: ' + mediaRecorderToStringify(btnStartRecording.recordRTC.getInternalRecorder().getInternalRecorder());
        }

        return info;
    }

    function saveToDiskOrOpenNewTab(recordRTC) {
        if(!recordRTC.getBlob().size) {
            var info = getFailureReport();
            console.log('blob', recordRTC.getBlob());
            console.log('recordrtc instance', recordRTC);
            console.log('report', info);

            if(mediaContainerFormat.value !== 'default') {
                alert('RecordRTC seems failed recording using ' + mediaContainerFormat.value + '. Please choose "default" option from the drop down and record again.');
            }
            else {
                alert('RecordRTC seems failed. Unexpected issue. You can read the email in your console log. \n\nPlease report using disqus chat below.');
            }

            if(mediaContainerFormat.value !== 'vp9' && DetectRTC.browser.name === 'Chrome') {
                alert('Please record using VP9 encoder. (select from the dropdown)');
            }
        }

        var fileName = getFileName(fileExtension);
        // upload to PHP server
        document.querySelector('#upload-to-server').disabled = false;
        document.querySelector('#upload-to-server').onclick = function() {
            if(!recordRTC) return alert('No recording found.');
            this.disabled = true;

            var button = this;
            uploadToServer(recordRTC, function(progress, fileURL) {
                if(progress === 'ended') {
                    button.disabled = false;
                    button.innerHTML = 'Click to download from server';
                    button.onclick = function() {
                        window.open(fileURL);
                    };
                    return;
                }
                button.innerHTML = progress;
            });
        };

    }

    function uploadToServer(recordRTC, callback) {
        var blob = recordRTC instanceof Blob ? recordRTC : recordRTC.blob;
        var fileType = blob.type.split('/')[0] || 'audio';

        if (fileType === 'audio') {
            video_id += '.' + (!!navigator.mozGetUserMedia ? 'ogg' : 'wav');
        } else {
            video_id += '.webm';
        }

        // create FormData
        var formData = new FormData();
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('video-filename', video_id);
        formData.append('video-blob', blob);
        document.getElementById('upload-to-server').style.display = "none";
        document.getElementById('uploading_msg').style.display = "block";

        $("#start_recording").attr('disabled', 'disabled');

        $.ajax({
            url: '{{ route("upload.video") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                saveQuestion();
            },
            error: function(resp){
                console.log(resp);
            }
        });

    }
    
    function makeXMLHttpRequest(url, data, callback) {
        var request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                if(request.responseText === 'success') {
                    callback('upload-ended');
                    return;
                }

                document.querySelector('.header').parentNode.style = 'text-align: left; color: red; padding: 5px 10px;';
                document.querySelector('.header').parentNode.innerHTML = request.responseText;
            }
        };

        request.upload.onloadstart = function() {
            callback('Upload started...');
        };

        request.upload.onprogress = function(event) {
            callback('Upload Progress ' + Math.round(event.loaded / event.total * 100) + "%");
        };

        request.upload.onload = function() {
            callback('progress-about-to-end');
        };

        request.upload.onload = function() {
            callback('Getting File URL..');
        };

        request.upload.onerror = function(error) {
            callback('Failed to upload to server');
        };

        request.upload.onabort = function(error) {
            callback('Upload aborted.');
        };

        request.open('POST', url);
        request.send(data);
    }
    function saveQuestion() {
        $.ajax({
            url: '/start-video',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                interview_id: $("#interview_id").val(),
                video_id: $("#video_id").val(),
                question: $("#question").val(),
                image_blob: imageBlob 
            },
            dataType: 'JSON',
            success: function (data) {
                $('#uploading_msg').hide();
                $('#success_upload').show();                

                location.reload();
            },
            error: function(resp){
                console.log(resp)
            }
        });
    }

    function getRandomString() {
        if (window.crypto && window.crypto.getRandomValues && navigator.userAgent.indexOf('Safari') === -1) {
            var a = window.crypto.getRandomValues(new Uint32Array(3)),
                token = '';
            for (var i = 0, l = a.length; i < l; i++) {
                token += a[i].toString(36);
            }
            return token;
        } else {
            return (Math.random() * new Date().getTime()).toString(36).replace(/\./g, '');
        }
    }

    function getFileName(fileExtension) {
        var d = new Date();
        var year = d.getUTCFullYear();
        var month = d.getUTCMonth();
        var date = d.getUTCDate();
        return 'RecordRTC-' + year + month + date + '-' + getRandomString() + '.' + fileExtension;
    }

    function SaveFileURLToDisk(fileUrl, fileName) {
        var hyperlink = document.createElement('a');
        hyperlink.href = fileUrl;
        hyperlink.target = '_blank';
        hyperlink.download = fileName || fileUrl;

        (document.body || document.documentElement).appendChild(hyperlink);
        hyperlink.onclick = function() {
           (document.body || document.documentElement).removeChild(hyperlink);

           // required for Firefox
           window.URL.revokeObjectURL(hyperlink.href);
        };

        var mouseEvent = new MouseEvent('click', {
            view: window,
            bubbles: true,
            cancelable: true
        });

        hyperlink.dispatchEvent(mouseEvent);
    }

    function getURL(arg) {
        var url = arg;

        if(arg instanceof Blob || arg instanceof File) {
            url = URL.createObjectURL(arg);
        }

        if(arg instanceof RecordRTC || arg.getBlob) {
            url = URL.createObjectURL(arg.getBlob());
        }

        if(arg instanceof MediaStream || arg.getTracks || arg.getVideoTracks || arg.getAudioTracks) {
            // url = URL.createObjectURL(arg);
        }

        return url;
    }

    function setVideoURL(arg, forceNonImage) {
        var url = getURL(arg);

        var parentNode = recordingPlayer.parentNode;
        parentNode.removeChild(recordingPlayer);
        parentNode.innerHTML = '';

        var elem = 'video';
        if(type == 'gif' && !forceNonImage) {
            elem = 'img';
        }
        if(type == 'audio') {
            elem = 'audio';
        }

        recordingPlayer = document.createElement(elem);
        
        if(arg instanceof MediaStream) {
            recordingPlayer.muted = true;
        }

        recordingPlayer.addEventListener('loadedmetadata', function() {
            if(navigator.userAgent.toLowerCase().indexOf('android') == -1) return;

            // android
            setTimeout(function() {
                if(typeof recordingPlayer.play === 'function') {
                    recordingPlayer.play();
                }
            }, 2000);
        }, false);

        recordingPlayer.poster = '';

        if(arg instanceof MediaStream) {
            recordingPlayer.srcObject = arg;
        }
        else {
            recordingPlayer.src = url;
        }

        if(typeof recordingPlayer.play === 'function') {
            recordingPlayer.play();
        }

        recordingPlayer.addEventListener('ended', function() {
            url = getURL(arg);
            
            if(arg instanceof MediaStream) {
                recordingPlayer.srcObject = arg;
            }
            else {
                recordingPlayer.src = url;
            }
        });

        parentNode.appendChild(recordingPlayer);
    }
    String.prototype.toHHMMSS = function () {
        var sec_num = parseInt(this, 10); // don't forget the second param
        var hours   = Math.floor(sec_num / 3600);
        var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
        var seconds = sec_num - (hours * 3600) - (minutes * 60);

        if (hours   < 10) {hours   = "0"+hours;}
        if (minutes < 10) {minutes = "0"+minutes;}
        if (seconds < 10) {seconds = "0"+seconds;}
        return hours+':'+minutes+':'+seconds;
    }
</script>