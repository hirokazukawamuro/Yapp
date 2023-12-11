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
const like = (postId) => {
  console.log("postId:", postId);
  axios
    .post("/like", { post_id: postId })
    .then((response) => {
      console.log(response);
    })
    .catch((error) => {
      console.error("いいねできず", error);
    });
};

onMounted(fetchMessages);
</script>

<template>
  <div>
    <h1>タイムライン</h1>
    <ul v-if="posts">
      <li v-for="post in posts" :key="post.id">
        <p>{{ post.post }}</p>
        <router-link to="/v/others" class="btn btn-ghost">{{ post.username }}
          <div class="profile-icon">
            <img v-if="post.user_image" v-bind:src="'/storage/images/' + post.user_image" alt="Image" />
          </div>
        </router-link>
        <img v-if="post.post_image" v-bind:src="'/storage/images/' + post.post_image" alt="Image" />

        <label class="swap">
          <input type="checkbox" @click="like(post.id)" />
          <div class="swap-on">
            <img src="../../img/red_heart.svg" class="sidebar" />
          </div>
          <div class="swap-off">
            <img src="../../img/white_heart.svg" class="sidebar" />
          </div>
        </label>

        <button class="btn btn-ghost">コメント</button>
      </li>
    </ul>
    <ul v-else>
      <li class="loading loading-spinner loading-sm">Loading...</li>
    </ul>
  </div>
</template>

<style scoped>
.profile-icon img {
  border-radius: 50%;
  width: 50px;
  height: 50px;
  object-fit: cover;
}

li {
  border-bottom: 1px solid rgb(246, 169, 233);
}
</style>
