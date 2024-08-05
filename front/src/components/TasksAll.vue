<template>
  <div>
    <h2>Все задачи</h2>
    <button 
        class="btn btn-primary"
            type="button" 
            data-bs-toggle="modal" 
            data-bs-target="#createTaskModal">
        Добавить новую
    </button>
    <table class="table table-bordered">
        <thead>
            <tr>
            <th scope="col">Название</th>
            <th scope="col">Описание</th>
            <th scope="col">Статус</th>
            <th scope="col">Взаимодействие</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="task in tasks" >
                <td>{{task.name}}</td>
                <td>{{task.description}}</td>
                <td v-if="task.status == 0">Новая</td>
                <td v-if="task.status == 1">Выполнена</td>
                <td>
                    <button 
                        class="btn btn-success"
                            type="button" 
                            data-bs-toggle="modal" 
                            data-bs-target="#updateTaskModal"
                            @click="getInfoTask(task)">
                        редактировать
                    </button>
                    <button 
                        class="btn btn-danger"
                        @click="deleteTask(task.id)">
                        удалить
                    </button>
                </td>
            </tr>
        </tbody>
    </table>


    <div class="modal" id="createTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавление новой задачи</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="name_task" class="form-label">Наименование</label>
                    <input type="text" v-model="name_task" class="form-control" id="name_task">
                </div>
                <div class="mb-3">
                    <label for="description_task" class="form-label">Описание</label>
                    <input type="text" v-model="description_task" class="form-control" id="description_task">
                </div>                
            </div>
            <div class="modal-footer">
                <button type="button" 
                    class="btn btn-secondary" 
                    data-bs-dismiss="modal"
                    @click="clearValues"
                >Отменить</button>
                <button 
                    type="button" 
                    class="btn btn-primary"
                    data-bs-dismiss="modal"
                    @click="addTask"
                >Добавить</button>
            </div>
            </div>
        </div>
    </div>

        <div class="modal" id="updateTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактирование задачи</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="name_task" class="form-label">Наименование</label>
                    <input type="text" v-model="name_task" class="form-control" id="name_task">
                </div>
                <div class="mb-3">
                    <label for="description_task" class="form-label">Описание</label>
                    <input type="text" v-model="description_task" class="form-control" id="description_task">
                </div>
                <div class="mb-3">
                    <label for="status_task" class="form-label">Статус</label>
                    <select class="form-select" v-model="status_task" aria-label="Default select example" id="status_task">
                        <option value="0">Новая</option>
                        <option value="1">Выполнена</option>
                    </select>
                </div>                 
            </div>
            <div class="modal-footer">
                <button type="button" 
                    class="btn btn-secondary" 
                    data-bs-dismiss="modal"
                    @click="clearValues"
                >Отменить</button>
                <button 
                    type="button" 
                    class="btn btn-primary"
                    data-bs-dismiss="modal"
                    @click="updateTask"
                >редактировать</button>
            </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
import TaskDataService from "../services/TaskDataService";
import { notify } from "@kyvg/vue3-notification";

export default {
  name: "tasks-list",
  data() {
    return {
      tasks: [],
      name_task: "",
      description_task: "",
      status_task: "",
      id_task: "",
    };
  },
  methods: {
    getTasks() {
        TaskDataService.getTasks()
            .then(response => {
                this.tasks = response.data;
            })
            .catch(e => {
                this.$notify({
                    text: e.response.data.message,
                    type: 'error'
                })
            });
    },
    addTask() {
        let data = {
            name: this.name_task,
            description: this.description_task
        };
        
        TaskDataService.addTask(data)
            .then(response => {
                this.getTasks();
                this.$notify({
                    text: 'Задача успешно добавлена',
                    type: 'success'
                })
            })
            .catch(e => {
                this.$notify({
                    text: e.response.data.message,
                    type: 'error'
                })
            });
        this.clearValues();
    },

    updateTask() {
        let data = {
            name: this.name_task,
            description: this.description_task,
            status: this.status_task
        };

        let id = this.id_task

        TaskDataService.updateTask(id, data)
            .then(response => {
                this.getTasks();
                this.$notify({
                    text: 'Задача успешно обновлена',
                    type: 'success'
                })
            })
            .catch(e => {
                this.$notify({
                    text: e.response.data.message,
                    type: 'error'
                })
            });
        this.clearValues();
    },

    getInfoTask(task) {
        this.description_task = task.description;
        this.name_task = task.name;
        this.status_task = task.status;
        this.id_task = task.id;
    },

    deleteTask(id) {
        TaskDataService.deleteTask(id)
            .then(response => {
                this.getTasks();
                this.$notify({
                    text: 'Задача успешно удалена',
                    type: 'success'
                })
            })
            .catch(e => {
                this.$notify({
                    text: e.response.data.message,
                    type: 'error'
                })
            });
        this.clearValues();
    },

    clearValues() {
        this.description_task = "";
        this.name_task = "";
        this.status_task = "";
        this.id_task = "";
    }
  },
  mounted() {
    this.getTasks();
  }
};
</script>