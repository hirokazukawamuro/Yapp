<script setup lang="ts">
import { ref, onMounted } from 'vue';
import axios from 'axios';

const posts = ref([]);

const fetchMessages = () => {
  axios
    .get('/timeline')
    .then((response) => {
      console.log(response.data);
      posts.value = response.data.posts;
    })
    .catch((error) => {
      console.error('メッセージの取得中にエラーが発生しました：', error);
    });
};

onMounted(fetchMessages);
</script>

<template>
  <div>
    <h1>タイムライン</h1>
    <ul  v-if="posts">
      <li v-for="post in posts" :key="post.id">
        {{ post.post }} 
      </li>
    </ul>
    <ul v-else>
      <li class="loading loading-spinner loading-sm">Loading...</li>
    </ul>
  </div>
</template>
