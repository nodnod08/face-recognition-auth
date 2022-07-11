<template>
    <div class="web-camera-container">
        <div class="camera-box" :class="{ flash: isShotPhoto }">
            <div class="camera-shutter" :class="{ flash: isShotPhoto }"></div>

            <div id="videoInternal">
                <video id="videoContainer" ref="camera" :width="450" :height="337.5" autoplay muted></video>
                <canvas id="photoTaken" ref="canvas" :width="450" :height="337.5"></canvas>
            </div>
        </div>

        <div v-if="!isLoading && !hideCapture" class="camera-shoot mt-10">
            <v-btn @click="takePhoto">
                <v-icon>mdi-camera</v-icon>
            </v-btn>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            hideCapture: false,
            isPhotoTaken: false,
            isShotPhoto: false,
            isLoading: false,
            shot: 0
        }
    },
    mounted() {
        this.initialize()
    },
    methods: {
        takePhoto() {
            if (!this.isPhotoTaken) {
                this.isShotPhoto = true

                const FLASH_TIMEOUT = 100

                setTimeout(() => {
                    this.isShotPhoto = false
                }, FLASH_TIMEOUT)
            }

            const context = this.$refs.canvas.getContext("2d")
            context.drawImage(this.$refs.camera, 0, 0, 450, 337.5)

            const canvas = document.getElementById("photoTaken").toDataURL("image/jpeg").replace("image/jpeg", "image/octet-stream")
            this.shot = this.shot + 1

            this.$nextTick(() => {
                this.$emit("onShot", { file: this.dataURLtoFile(canvas, `PHOTO_${this.shot}`), base64: canvas })
            })
        },
        dataURLtoFile(dataurl, filename) {
            var arr = dataurl.split(","),
                mime = arr[0].match(/:(.*?);/)[1],
                bstr = atob(arr[1]),
                n = bstr.length,
                u8arr = new Uint8Array(n)

            while (n--) {
                u8arr[n] = bstr.charCodeAt(n)
            }

            return new File([u8arr], filename, { type: mime })
        },
        initialize() {
            const video = document.getElementById("videoContainer")
            const videoInternal = document.getElementById("videoInternal")
            Promise.all([faceapi.nets.tinyFaceDetector.loadFromUri("/js/models"), faceapi.nets.faceLandmark68Net.loadFromUri("/js/models"), faceapi.nets.faceRecognitionNet.loadFromUri("/js/models"), faceapi.nets.faceExpressionNet.loadFromUri("/js/models")]).then(startVideo)

            function startVideo() {
                navigator.getUserMedia(
                    { video: {} },
                    (stream) => (video.srcObject = stream),
                    (err) => console.error(err)
                )
            }

            video.addEventListener("play", () => {
                const canvas = faceapi.createCanvasFromMedia(video)
                videoInternal.append(canvas)
                const displaySize = { width: video.width, height: video.height }
                faceapi.matchDimensions(canvas, displaySize)
                setInterval(async () => {
                    const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceExpressions()
                    const resizedDetections = faceapi.resizeResults(detections, displaySize)
                    canvas.getContext("2d").clearRect(0, 0, canvas.width, canvas.height)
                    faceapi.draw.drawDetections(canvas, resizedDetections)
                    faceapi.draw.drawFaceLandmarks(canvas, resizedDetections)
                    faceapi.draw.drawFaceExpressions(canvas, resizedDetections)
                }, 100)
            })
        },
        hideButton(data) {
            this.hideCapture = data
        }
    }
}
</script>

<style lang="scss" scoped>
.web-camera-container {
    margin-top: 2rem;
    margin-bottom: 2rem;
    padding: 2rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 500px;

    .camera-button {
        margin-bottom: 2rem;
    }

    .camera-box {
        .camera-shutter {
            opacity: 0;
            width: 450px;
            height: 337.5px;
            background-color: #fff;
            position: absolute;

            &.flash {
                opacity: 1;
            }
        }

        #videoInternal {
            #photoTaken {
                display: none;
            }
        }
    }
}
</style>
