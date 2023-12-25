<script setup lang="ts">
import { ref, onMounted } from "vue";
import axios from "axios";

const user = ref();
const name = ref("");
const profile = ref("");
const image_1 = ref("");
const image_2 = ref("");
const userId = defineProps(["userId"]);
const followings_number = ref();
const followed_number = ref();
const posts = ref([]);
const isFollowing = ref(false);

const showOthersProfile = () => {
  axios
    .get("/others", { params: { userId: userId } })
    .then((response) => {
      console.log(response.data);
      user.value = response.data.user;
      name.value = response.data.user.name;
      profile.value = response.data.user.profile;
      image_1.value = response.data.user.image_1;
      image_2.value = response.data.user.image_2;
    })
    .catch((error) => {
      console.error("メッセージの取得中にエラーが発生しました：", error);
    });
};

const CountFollowings = () => {
  axios
    .get("/follow/followings_number", { params: { userId: userId } })
    .then((response) => {
      followings_number.value = response.data.followings_number;
    })
    .catch((error) => {
      console.error("Cannot get the number", error);
    });
};

const followCheck = () => {
  axios
    .get("/follow/check", { params: { userId: userId } })
    .then((response) => {
      isFollowing.value = response.data.isFollowing;
    })
    .catch((error) => {
      console.error("no idea", error);
    });
};
const CountFollowed = () => {
  axios
    .get("/follow/followed_number", { params: { userId: userId } })
    .then((response) => {
      followed_number.value = response.data.followed_number;
    })
    .catch((error) => {
      console.error("Cannot get the number", error);
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

const destroy = (followeeId) => {
  axios
    .post("/follow/destroy", { followee_id: followeeId })
    .then((response) => {
      console.log(response);
    })
    .catch((error) => {
      console.error("フォロー解除できず", error);
    });
};

const fetchMessages = () => {
  axios
    .get("/timeline", { params: { userId: userId } })
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

const toggleFollow = (userId) => {
  if (isFollowing.value) {
    destroy(userId);
  } else {
    store(userId);
  }
  isFollowing.value = !isFollowing.value;
};

onMounted(() => {
  showOthersProfile();
  CountFollowings();
  CountFollowed();
  fetchMessages();
  followCheck();
});
</script>

<template>
  <main>
    <div v-if="user">
      <div class="profile-zone">
        <div class="background-image">
          <img v-if="image_2" v-bind:src="'/storage/images/' + image_2" alt="Image 2" />
        </div>
        <div class="profile-image">
          <img v-if="image_1" v-bind:src="'/storage/images/' + image_1" alt="Image 1" />
        </div>
        <b>{{ user.name }}</b>
        <button v-if="isFollowing" @click="toggleFollow(user.id)" class="btn btn-outline btn-error">
          フォロー解除
        </button>
        <button v-else @click="toggleFollow(user.id)" class="btn btn-neutral">
          フォロー
        </button>
        <p v-if="profile !== null">{{ user.profile }}</p>

        <p>{{ followings_number }} フォロー中</p>
        <p>{{ followed_number }} フォロワー</p>
      </div>
    </div>
    <div v-else>
      <p class="loading loading-spinner loading-sm">Loading...</p>
    </div>

    <div class="post">
      <ul v-if="posts">
        <li v-for="post in posts" :key="post.id">
          <p>{{ post.post }}</p>
          <b>{{ post.username }}</b>
          <div class="profile-icon">
            <img v-if="post.user_image" v-bind:src="'/storage/images/' + post.user_image" alt="Image" />
          </div>
          <img v-if="post.post_image" v-bind:src="'/storage/images/' + post.post_image" alt="Image" />
        </li>
      </ul>
      <ul v-else>
        <li class="loading loading-spinner loading-sm">Loading...</li>
      </ul>
    </div>
    <div class="post"></div>
  </main>
</template>

<style scoped>
.profile-zone {
  border-bottom: 1px solid rgb(246, 169, 233);
}

.profile-image img {
  border-radius: 50%;
  width: 100px;
  height: 100px;
  object-fit: cover;
}

.profile-icon img {
  border-radius: 50%;
  width: 50px;
  height: 50px;
  object-fit: cover;
}

.edit-image {
  position: relative;
  display: inline-block;
}

li {
  border-bottom: 1px solid rgb(246, 169, 233);
}

/* 
  .file-input-1 {
    position: absolute;
    top: 310px;
    left: 40px;
    width: 90%;
    height: 38%;
    opacity: 0;
    cursor: pointer;
  }

  .file-input-2 {
    position: absolute;
    top: 50px;
    left: 40px;
    width: 90%;
    height: 38%;
    opacity: 0;
    cursor: pointer;
  } */
</style>
