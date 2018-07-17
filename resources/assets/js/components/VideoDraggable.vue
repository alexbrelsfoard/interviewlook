<template>
    <div class="row">
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Interview Question</h4>
              </div>
              <div class="modal-body">
                    <video :src="'/uploads/videos/'+modalVideoId+'.webm'" controls>
                    </video>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <div id="completed-look" class="col-md-6 col-md-offset-0" style="display:none;">
            <a href="/looks" style="position: absolute;right: 31px;z-index: 9;" class="btn btn-green pull-right">Save</a>
            <section class="list">
                <h3 id="right-half-title">Complete Look</h3>
                <draggable class="drag-area" :list="tasksNotCompletedNew" :options="{animation:200, group:'status'}" :element="'article'" @add="onAdd($event, false)"  @change="update">
                    <article class="card row" v-for="(task, index) in tasksNotCompletedNew" :key="task.id" :data-id="task.id">
                        <div class="snapshot-image col-md-3"  @click="openVideo(task.video_id)">
                            <img v-if="task.img_url" :src="'/uploads/thumbnails/'+task.img_url">
                        </div>
                        <div class="snapshot-name col-md-8"  @click="openVideo(task.video_id)">
                            {{ task.title }}
                        </div>
                        <div class="col-md-1 text-right">
                            <a class="close-btn" @click="deleteTask(task.id)">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </a>
                        </div>
                    </article>
                </draggable>
            </section>
        </div>
        <div id="saved-questions" class="col-md-12">
            <section class="list">
                <h3 id="right-half-title">Saved Questions</h3>
                <draggable class="drag-area"  :list="tasksCompletedNew" :options="{animation:200, group:'status'}" :element="'article'" @add="onAdd($event, true)"  @change="update">
                    <article class="card row" v-for="(task, index) in tasksCompletedNew" :key="task.id" :data-id="task.id">
                        <div class="snapshot-image col-md-3" @click="openVideo(task.video_id)">
                            <img v-if="task.img_url" :src="'/uploads/thumbnails/'+task.img_url">
                        </div>
                        <div class="snapshot-name col-md-8" @click="openVideo(task.video_id)">
                            {{ task.title }}
                        </div>
                        <div class="col-md-1 text-right">
                            <a class="close-btn" @click="deleteTask(task.id)">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </a>
                        </div>
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
            onAdd(event, status) {
                let id = event.item.getAttribute('data-id');
                axios.patch('/looks/' + id, {
                    status: status
                }).then((response) => {
                    console.log(response.data);
                }).catch((error) => {
                    console.log(error);
                })
            },
            update() {
                this.tasksNotCompletedNew.map((task, index) => {
                    task.order = index + 1;
                });

                this.tasksCompletedNew.map((task, index) => {
                    task.order = index + 1;
                });

                let tasks = this.tasksNotCompletedNew.concat(this.tasksCompletedNew);

                axios.put('/looks/updateAll', {
                    tasks: tasks
                }).then((response) => {
                    console.log(response.data);
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
            }

        }
    }
</script>

<style scoped>
    #completed-look {
        position: unset;
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
        margin-top: 6px;
        display: block;
    }
    .list>header {
      font-weight: bold;
      color: white;
      text-align: center;
      font-size: 20px;
      line-height: 28px;
    }

    .list .card {
      background-color: #FFF;
      padding: 15px 10px;
      cursor: pointer;
      font-size: 16px;
      font-weight: bolder;
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