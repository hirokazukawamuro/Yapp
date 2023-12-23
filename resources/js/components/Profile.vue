<script setup lang="ts">
import { ref, onMounted } from "vue";
import axios from "axios";

const user = ref();
const name = ref("");
const profile = ref("");
const image_1 = ref("");
const image_2 = ref("");
const posts = ref([]);
const followings_number = ref();
const followed_number = ref();

const showProfile = () => {
  axios
    .get("/profile")
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

const updateProfile = () => {
  const formData = new FormData();
  formData.append("image_1", image_1.value);
  formData.append("image_2", image_2.value);
  formData.append("name", name.value);
  formData.append("profile", profile.value);
  axios
    .post("/update", formData)
    .then(() => {
      console.log(image_1.value);
      console.log(image_2.value);
    })
    .catch((error) => {
      console.error("プロフィールの更新中にエラーが発生しました：", error);
    });
};

const fileSelected = (event, image) => {
  if (image === "image_1") {
    image_1.value = event.target.files[0];
    console.log(image_1.value);
  } else if (image === "image_2") {
    image_2.value = event.target.files[0];
    console.log(image_2.value);
  }
};

const fetchAuthUserMessages = () => {
  axios
    .get("/my_timeline")
    .then((response) => {
      console.log(response.data);
      posts.value = response.data.posts;
    })
    .catch((error) => {
      console.error("メッセージの取得中にエラーが発生しました：", error);
    });
};

const CountFollowings = () => {
  axios
    .get("/follow/followings_number")
    .then((response) => {
      followings_number.value = response.data.followings_number;
    })
    .catch((error) => {
      console.error("Cannot get the number", error);
    });
};

const CountFollowed = () => {
  axios
    .get("/follow/followed_number")
    .then((response) => {
      followed_number.value = response.data.followed_number;
    })
    .catch((error) => {
      console.error("Cannot get the number", error);
    });
};

onMounted(() => {
  showProfile();
  fetchAuthUserMessages();
  CountFollowings();
  CountFollowed();
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

        <button class="btn" onclick="my_modal_1.showModal()">プロフィールを編集</button>
        <dialog id="my_modal_1" class="modal">
          <div class="modal-box">
            <h3 class="font-bold text-lg">プロフィールを編集</h3>
            <form @submit.prevent="updateProfile" enctype="multipart/form-data">
              <img v-if="image_2" v-bind:src="'/storage/images/' + image_2" alt="Image 2" class="edit-image" />
              <input type="file" name="image_2" accept="image/*" @change="fileSelected($event, 'image_2')"
                class="file-input-2" />
              <img v-if="image_1" v-bind:src="'/storage/images/' + image_1" alt="Image 1" class="edit-image" />
              <input type="file" name="image_1" accept="image/*" @change="fileSelected($event, 'image_1')"
                class="file-input-1" />
              <input type="hidden" name="_token" />
              <div>
                <span>名前</span>
                <input type="text" name="name" v-model="name" />
              </div>
              <div>
                <span>プロフィール</span>
                <textarea name="profile" v-model="profile"></textarea>
              </div>
              <input type="submit" value="保存" class="bg-black text-white px-4 py-2 border rounded cursor-pointer" />
            </form>
          </div>
          <form method="dialog" class="modal-backdrop">
            <button>close</button>
          </form>
        </dialog>

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
