<script setup lang="ts">
import { ref, onMounted } from "vue";
import axios from "axios";

const posts = ref([]);
const likedPosts = ref([]);
const reposts = ref([]);
const liked_number = ref();
const reposted_number = ref();

const checkLikeStatus = () => {
  axios
    .get("/checkLikeStatus")
    .then((response) => {
      likedPosts.value = response.data.liked_exists.map((item) => item.post_id);
      posts.value.forEach((post) => {
        post.isLiked = isLiked(post.id);
      });
    })
    .catch((error) => {
      console.error("既にいいねされた投稿を取得できず：", error);
    });
};

const checkRepostStatus = () => {
  axios
    .get("/checkRepostStatus")
    .then((response) => {
      reposts.value = response.data.reposted_exists.map((item) => item.post_id);
      posts.value.forEach((post) => {
        post.isReposted = isReposted(post.id);
      });
    })
    .catch((error) => {
      console.error("既にリポストされた投稿を取得できず：", error);
    });
};
const toggleLike = (postId) => {
  if (isLiked(postId)) {
    unlike(postId);
  } else {
    like(postId);
  }
};

const toggleRepost = (postId) => {
  if (isReposted(postId)) {
    undoRepost(postId);
  } else {
    repost(postId);
  }
};

const fetchMessages = () => {
  axios
    .get("/timeline")
    .then((response) => {
      console.log(response.data);
      posts.value = response.data.posts.map((post) => {
        return { ...post, isLiked: false, isReposted: false };
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
    .then(() => {
      likedPosts.value.push(postId);
      liked_number.value++;
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

const repost = (postId) => {
  axios
    .post("/repost", { post_id: postId })
    .then(() => {
      reposts.value.push(postId);
      reposted_number.value++;

      posts.value = posts.value.map((post) => {
        if (post.id === postId) {
          post.isReposted = true;
        }
        return post;
      });
    })
    .catch((error) => {
      console.error("リポストできず", error);
    });
};

const unlike = (postId) => {
  console.log("postId:", postId);
  axios
    .post("/unlike", { post_id: postId })
    .then(() => {
      console.log("いいねを解除しました。");
      likedPosts.value = likedPosts.value.filter((id) => id !== postId);
      liked_number.value--;
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

const undoRepost = (postId) => {
  console.log("postId:", postId);
  axios
    .post("/undorepost", { post_id: postId })
    .then(() => {
      console.log("リポストを解除しました。");
      reposts.value = reposts.value.filter((id) => id !== postId);
      reposted_number.value--;
      posts.value = posts.value.map((post) => {
        if (post.id === postId) {
          post.isReposted = false;
        }
        return post;
      });
    })
    .catch((error) => {
      console.error("リポスト解除できず", error);
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

const isReposted = (postId) => {
  for (const id of reposts.value) {
    if (id === postId) {
      return true;
    }
  }
  return false;
};

const CountLikes = () => {
  axios
    .get("/like/liked_number")
    .then((response) => {
      liked_number.value = response.data.liked_number;
    })
    .catch((error) => {
      console.error("Cannot get the number", error);
    });
};

const CountReposted = () => {
  axios
    .get("/repost/reposted_number")
    .then((response) => {
      reposted_number.value = response.data.reposted_number;
    })
    .catch((error) => {
      console.error("Cannot get the number", error);
    });
};

onMounted(() => {
  fetchMessages();
  checkLikeStatus();
  checkRepostStatus();
  CountLikes();
  CountReposted();
});
</script>

<template>
  <div>
    <h1>タイムライン</h1>
    <ul v-if="posts">
      <li v-for="post in posts" :key="post.id">
        <p>{{ post.post }}</p>
        <router-link
          :to="{ name: 'others', params: { userId: Number(post.user_id) } }"
          class="btn btn-ghost"
          >{{ post.username }}
          <div class="profile-icon">
            <img
              v-if="post.user_image"
              v-bind:src="'/storage/images/' + post.user_image"
              alt="Image"
            />
          </div>
        </router-link>
        <img
          v-if="post.post_image"
          v-bind:src="'/storage/images/' + post.post_image"
          alt="Image"
        />

        <div class="like">
          <input type="checkbox" @click="toggleLike(post.id)" />
          <div v-if="isLiked(post.id)">
            <img src="../../img/red_heart.svg" class="sidebar" />{{ liked_number }}
          </div>
          <div v-else>
            <img src="../../img/white_heart.svg" class="sidebar" />{{ liked_number }}
          </div>
        </div>

        <div class="repost">
          <input type="checkbox" @click="toggleRepost(post.id)" />
          <div v-if="isReposted(post.id)">
            <img src="../../img/green_repost.svg" class="sidebar" /> {{ reposted_number }}
          </div>
          <div v-else>
            <img src="../../img/white_repost.svg" class="sidebar" />{{ reposted_number }}
          </div>
        </div>

        <div class="comment">
          <button class="btn btn-ghost">
            <img src="../../img/comment.svg" class="sidebar" />
          </button>
        </div>
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

.like {
  position: relative;
}

.like input {
  position: absolute;
  top: 0;
  left: 0;
  opacity: 0;
  cursor: pointer;
  width: 100%;
  height: 100%;
}

.repost {
  position: relative;
}

.repost input {
  position: absolute;
  top: 0;
  left: 0;
  opacity: 0;
  cursor: pointer;
  width: 100%;
  height: 100%;
}
</style>
