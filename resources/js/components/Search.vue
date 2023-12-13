<script setup lang="ts">
import { ref } from "vue";
import axios from "axios";

const posts = ref([]);
const users = ref([]);
const searchTerm = ref("");

const search = () => {
  console.log(searchTerm);
  if (searchTerm.value.length < 3 || searchTerm.value.length > 50) {
    return;
  }

  axios
    .get("/search", { params: { searchTerm: searchTerm.value } })
    .then((response) => {
      console.log(response.data);
      users.value = response.data.users;
      posts.value = response.data.posts;
    })
    .catch((error) => {
      console.error("検索できず", error);
    });
};
</script>

<template>
  <div class="search">
    <input type="text" name="searchTerm" v-model="searchTerm" @input="search" placeholder="検索" class="input" />
    <h1>何かお探しですか？</h1>
    <ul>
      <li v-for="user in users" :key="user.id">
        <div v-if="user">
          <p>{{ user.name }}</p>
        </div>
        <div v-else>
          <p>検索結果はありません</p>
        </div>
      </li>
      <li v-for="post in posts" :key="post.id">
        <div v-if="post">
          <p>{{ post.post }}</p>
        </div>
        <div v-else>
          <p>検索結果はありません</p>
        </div>
      </li>
    </ul>
  </div>
</template>

<style>
@media (min-width: 1024px) {
  .search {
    min-height: 100vh;
    display: flex;
    align-items: center;
  }
}
</style>
