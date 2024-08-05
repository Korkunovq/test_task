import http from "../http-common.js";

class TaskDataService {
  getTasks() {
    return http.get("/tasks");
  }

  addTask(data) {
    return http.post("/task", data);
  }

  updateTask(id, data) {
    return http.put(`/task/${id}`, data);
  }

  deleteTask(id) {
    return http.delete(`/task/${id}`);
  }
}

export default new TaskDataService();