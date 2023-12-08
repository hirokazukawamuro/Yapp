<script setup lang="ts">
import { ref, onMounted } from "vue";
import axios from "axios";

const users = ref([]);

const fetchUsers = () => {
  axios
    .get("/allusers")
    .then((response) => {
      console.log(response.data);
      users.value = response.data.users;
    })
    .catch((error) => {
      console.error("ユーザとれず。。。", error);
    });
};

const store = (followeeId) => {
  axios
    .post("/follow", { followee_id: followeeId })
    .then((response) => {
      console.log(response);
    })
    .catch((error) => {
      console.error("フォローできず", error);
    });
};

const destroy = (id) => {
  axios
    .post("/follow/{id}/destroy")
    .then((response) => {
      console.log(response);
    })
    .catch((error) => {
      console.error("フォロー解除できず", error);
    });
};

onMounted(fetchUsers);
</script>
<template>
  <div v-for="user in users" :key="user.id">
    <div>{{ user.name }}</div>
    <button @click="store(user.id)">フォローする</button>
    <button @click="destroy(user.id)">フォロー解除</button>
  </div>
</template>
