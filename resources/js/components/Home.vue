<script setup lang="ts">
import { ref, onMounted } from "vue";
import axios from "axios";

const posts = ref([]);
const likedPosts = ref([]);

const checkLikeStatus = () => {
  axios
    .get("/checkLikeStatus")
    .then((response) => {
      console.log(response.data);
      console.log(likedPosts.value);
      likedPosts.value = response.data.liked_exists.map((item) => item.post_id);
      posts.value.forEach((post) => {
        post.isLiked = isLiked(post.id);
      });
    })
    .catch((error) => {
      console.error("既にいいねされた投稿を取得できず：", error);
    });
};

const toggleLike = (postId) => {
  if (isLiked(postId)) {
    unlike(postId);
  } else {
    like(postId);
  }
};

const fetchMessages = () => {
  axios
    .get("/timeline")
    .then((response) => {
      console.log(response.data);
      posts.value = response.data.posts.map((post) => {
        return { ...post, isLiked: false };
      });
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
      console.log(likedPosts.value);
      likedPosts.value.push(postId);

      posts.value = posts.value.map((post) => {
        if (post.id === postId) {
          post.isLiked = true;
        }
        return post;
      });
    })
    .catch((error) => {
      console.error("いいねできず", error);
    });
};

const unlike = (postId) => {
  console.log("postId:", postId);
  axios
    .post("/unlike", { post_id: postId })
    .then(() => {
      console.log("いいねを解除しました。");
      likedPosts.value = likedPosts.value.filter((id) => id !== postId);

      posts.value = posts.value.map((post) => {
        if (post.id === postId) {
          post.isLiked = false;
        }
        return post;
      });
    })
    .catch((error) => {
      console.error("いいね解除できず", error);
    });
};

const isLiked = (postId) => {
  for (const id of likedPosts.value) {
    if (id === postId) {
      return true;
    }
  }
  return false;
};

onMounted(() => {
  fetchMessages();
  checkLikeStatus();
});
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
          <input type="checkbox" @click="toggleLike(post.id)" />
          <div class="swap-on" v-if="isLiked(post.id)">
            <img src="../../img/red_heart.svg" class="sidebar" />
          </div>
          <div class="swap-off" v-else>
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
