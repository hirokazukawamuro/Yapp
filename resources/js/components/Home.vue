<script setup lang="ts">
import { ref, onMounted } from "vue";
import axios from "axios";

const posts = ref([]);

const fetchMessages = () => {
  axios
    .get("/timeline")
    .then((response) => {
      console.log(response.data);
      posts.value = response.data.posts;
    })
    .catch((error) => {
      console.error("メッセージの取得中にエラーが発生しました：", error);
    });
};
const isLiked = ref(false);

const toggleHeart = () => {
  isLiked.value = !isLiked.value;
};

onMounted(fetchMessages);
</script>
<style scoped>
/* Scoped styles for the Heart component */
button {
  transition: color 0.3s ease;
  /* カラーの変化をスムーズにするためのトランジション */
}

/* ボタンが押された時のスタイル */
button:active,
button:focus {
  outline: none;
  /* ボタンがフォーカスされたときのアウトラインを非表示にする */
}
</style>
<template>
  <div>
    <h1>タイムライン</h1>
    <ul v-if="posts">
      <li v-for="post in posts" :key="post.id">
        <p>{{ post.post }}</p>
        <img v-if="post.image" v-bind:src="'/storage/images/' + post.image" alt="Image" />
        <button @click="toggleHeart" :class="{ 'text-red-500': isLiked }">
          <i class="fad fa-heart fa-2x"></i>
        </button>
      </li>
    </ul>
    <ul v-else>
      <li class="loading loading-spinner loading-sm">Loading...</li>
    </ul>
  </div>
</template>
