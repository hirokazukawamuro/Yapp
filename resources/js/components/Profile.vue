<script setup lang="ts">
import { ref, onMounted } from "vue";
import axios from "axios";

const user = ref();
const name = ref("");
const profile = ref("");
const image_1 = ref("");
const image_2 = ref("");

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
    .then((response) => {
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

onMounted(showProfile);
</script>

<template>
  <main>
    <div v-if="user">
      <span>{{ user.name }}</span>
      <p>{{ user.profile }}</p>
      <img v-if="image_1" v-bind:src="'/storage/images/' + image_1" alt="Image 1" />
      <img v-if="image_2" v-bind:src="'/storage/images/' + image_2" alt="Image 2" />
    </div>
    <div v-else>
      <p class="loading loading-spinner loading-sm">Loading...</p>
    </div>

    <button class="btn" onclick="my_modal_1.showModal()">プロフィールを編集</button>
    <dialog id="my_modal_1" class="modal">
      <div class="modal-box">
        <h3 class="font-bold text-lg">プロフィールを編集</h3>
        <form @submit.prevent="updateProfile" enctype="multipart/form-data">
          <img v-if="image_1" v-bind:src="'/storage/images/' + image_1" alt="Image 1" />
          <input type="file" name="image_1" accept="image/*" @change="fileSelected($event, 'image_1')" />
          <img v-if="image_2" v-bind:src="'/storage/images/' + image_2" alt="Image 2" />
          <input type="file" name="image_2" accept="image/*" @change="fileSelected($event, 'image_2')" />
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
  </main>
</template>
