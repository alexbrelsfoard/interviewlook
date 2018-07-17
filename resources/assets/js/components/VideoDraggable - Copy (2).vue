<template>
    <div class="row">
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Video Preview</h4>
              </div>
              <div class="modal-body">
                    <video :src="'uploads/videos/'+modalVideoId+'.webm'" controls>
                    </video>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <div id="completed-look" class="col-md-6 col-md-offset-0" style="display:none;">
            <section class="list">
                <div>
                    <h3 id="right-half-title" style="float: left;">Complete Look</h3>
                    <button @click="addLook" class="btn-green pull-right" style="margin-top: 6px;">Add New Look</button>
                </div>
                <div class="interview-div" v-for="(interview, key) in tasksNotCompletedNew" :look-id="interview.id">
                    <div class="interview-title">
                        <input @keyup="interviewTitle(key)" v-model="interview.title">
                        <a class="close-btn" @click="deleteLook(interview.id)" v-if="interview.looks.length == 0">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </a>
                    </div>

                    <draggable class="drag-area" :list="interview.looks"  :options="{animation:200, group:'status'}" :element="'article'" @add="onAdd($event, false)" @change="update">
                        <article class="card row" v-for="(task, index) in interview.looks" :key="task.id" :data-id="task.id">
                            <div class="row" @click="openVideo(task.video_id)">
                                <div class="snapshot-image col-md-3">
                                    <img v-if="task.img_url" :src="'uploads/thumbnails/'+task.img_url">
                                </div>
                                <div class="snapshot-name col-md-9">
                                    {{ task.title }}
                                </div>
                            </div>
                            <a class="close-btn" @click="deleteTask(task.id)">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </a>
                        </article>
                    </draggable>

                </div>

            </section>
        </div>
        <div id="saved-questions" class="col-md-12">
            <section class="list">
                <h3 id="right-half-title">Saved Questions</h3>
                <draggable class="drag-area" :list="tasksCompletedNew" :options="{animation:200, group:'status'}" :element="'article'" @add="onAdd($event, true)"  @change="update">
                    <article class="card" v-for="(task, index) in tasksCompletedNew" :key="task.id" :data-id="task.id">
                        <div class="row" @click="openVideo(task.video_id)">
                            <div class="snapshot-image col-md-3">
                                <img v-if="task.img_url" :src="'uploads/thumbnails/'+task.img_url">
                            </div>
                            <div class="snapshot-name col-md-9">
                                {{ task.title }}
                            </div>
                        </div>
                        <a class="close-btn" @click="deleteTask(task.id)">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </a>
                    </article>
                </draggable>
            </section>
        </div>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'

    export default {
        components: {
            draggable
        },
        props: ['tasksCompleted', 'tasksNotCompleted'],
        data() {
            return {
                tasksNotCompletedNew: this.tasksNotCompleted,
                tasksCompletedNew: this.tasksCompleted,
                modalVideoId: ''
            }
        },
        methods: {
            interviewTitle($index) {
                axios.put('/looks/edit-interview', {
                    id: this.tasksNotCompletedNew[$index].id,
                    title: this.tasksNotCompletedNew[$index].title
                }).then((response) => {
                    console.log(response);
                }).catch((error) => {
                    console.log(error);
                })
            },
            onAdd(event, status) {
            },
            update() {
                var list = [];
                for (var key in this.tasksNotCompletedNew) {
                    for ( var index in this.tasksNotCompletedNew[key].looks ) {
                        list.push({
                            id: this.tasksNotCompletedNew[key].looks[index].id,
                            order: parseInt(index)+1,
                            status: 0,
                            interview_id: this.tasksNotCompletedNew[key].id
                        })
                    }
                }

                for (var index in this.tasksCompletedNew) {
                    list.push({
                        id: this.tasksCompletedNew[index].id,
                        order: parseInt(index)+1,
                        status: 1,
                        interview_id: 0
                    })
                }
                console.log(list)
                axios.put('/looks/updateAll', {
                    tasks: list
                }).then((response) => {
                    console.log(response);
                }).catch((error) => {
                    console.log(error);
                })

            },
            openVideo($video_id){
                $('#exampleModal').modal('show');
                this.modalVideoId = $video_id;
            },
            deleteTask($id){
                var confirmation = confirm("Are you sure you want to remove this question?");
                if (confirmation) {
                    axios.put('/video/delete', { id: $id }).then((response) => {
                        $('article[data-id="'+$id+'"]').remove()
                    }).catch((error) => {
                        console.log(error);
                    })
                }
            },
            deleteLook($id) {
                axios.put('/look/delete', { id: $id }).then((response) => {
                    $('[look-id="'+$id+'"]').remove()
                }).catch((error) => {
                    console.log(error);
                })
            },
            addLook(){
                axios.put('/looks/add-interview').then((response) => {
                    this.getData();
                }).catch((error) => {
                    console.log(error);
                })
            },
            getData() {
                axios.get('/looks/data').then((response) => {
                    this.tasksCompletedNew = response.data.videosCompiled;
                    this.tasksNotCompletedNew = response.data.videosSaved;
                }).catch((error) => {
                    console.log(error);
                })
            }
        }
    }
</script>

<style scoped>
    .interview-title{
        position: relative;
        display: inline-block;
        width: 100%;
    }
    .interview-title input{
        margin: 0;
        background: #f9f9f9;
        border: 1px solid #ccc;
        border-bottom: none;
        width: 100%;
        padding: 11px;
        font-size: 17px;
        text-transform: uppercase;
    }
    .interview-title a {
        right: 12px;
        top: 12px;
    }
    .interview-title a i {
        color: #d14f4f;
    }
    video{
        width: 100%;
        max-width: 100%;
    }
    .modal-title{
        text-transform: none;
    }
    .snapshot-name {
        text-align: left;
    }
    .close-btn{
        position: absolute;
        right: 10px;
        top: 5px;
    }
    .list>header {
      font-weight: bold;
      color: white;
      text-align: center;
      font-size: 20px;
      line-height: 28px;
    }

    .list .card {
      position: relative;
      background-color: #FFF;
      cursor: pointer;
      font-size: 16px;
      font-weight: bolder;
    }
    .list .card .row{
        padding: 15px 10px;
    }
    .list .card:hover {
      background-color: #F0F0F0;
    }
    img {
        max-height: 50px;
        width: auto;
        max-width: 100%;
        height: auto;
    }
    .fa-times{
        font-size: 17px;
        color: #9f9f9f;
    }
    .fa-times:hover{
        color: #333;
    }
</style>