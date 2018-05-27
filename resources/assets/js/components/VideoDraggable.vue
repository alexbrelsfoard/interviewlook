<template>
    <div class="row">
        <div id="completed-look" class="col-md-6 col-md-offset-0" style="display:none;">
            <section class="list">
                <h3 id="right-half-title">Complete Look</h3>
                <draggable class="drag-area" :list="tasksNotCompletedNew" :options="{animation:200, group:'status'}" :element="'article'" @add="onAdd($event, false)"  @change="update">
                    <article class="card" v-for="(task, index) in tasksNotCompletedNew" :key="task.id" :data-id="task.id">
                        <div class="snapshot-image col-md-3">

                        </div>
                        <div class="snapshot-name col-md-9">
                            {{ task.title }}
                        </div>
                    </article>
                </draggable>
            </section>
        </div>
        <div id="saved-questions" class="col-md-12">
            <section class="list">
                <h3 id="right-half-title">Saved Questions</h3>
                <draggable class="drag-area"  :list="tasksCompletedNew" :options="{animation:200, group:'status'}" :element="'article'" @add="onAdd($event, true)"  @change="update">
                    <article class="card" v-for="(task, index) in tasksCompletedNew" :key="task.id" :data-id="task.id">
                        <div class="snapshot-image col-md-3">

                        </div>
                        <div class="snapshot-name col-md-9">
                            {{ task.title }}
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
                tasksCompletedNew: this.tasksCompleted
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
            }

        }
    }
</script>

<style>

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
</style>