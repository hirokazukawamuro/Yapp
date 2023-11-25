<script setup lang="ts">
import { ref, onMounted } from 'vue';
import axios from 'axios';

const user = ref();
const name = ref('');
const profile = ref('');
const showModal = ref(false);

const showProfile = () => {
  axios
    .get('/profile')
    .then((response) => {
      console.log(response.data);
      user.value = response.data.user;
      name.value = response.data.user.name;
      profile.value = response.data.user.profile;
    })
    .catch((error) => {
      console.error('メッセージの取得中にエラーが発生しました：', error);
    });
};

const updateProfile = () => {
  axios
    .post('/update', { name: name.value, profile: profile.value })
    .then((response) => {
      console.log(response.data);
      showModal.value = false;
    })
    .catch((error) => {
      console.error('プロフィールの更新中にエラーが発生しました：', error);
    });
};

onMounted(showProfile );
</script>

<template>
  <main>
  <div v-if="user">
    <span >{{ user.name }}</span>
    <p>{{ user.profile }}</p>
  </div>
  <div v-else>
      <p class="loading loading-spinner loading-sm">Loading...</p>
  </div>
  
<button class="btn" onclick="my_modal_1.showModal()">プロフィールを編集</button>
<dialog  id="my_modal_1" class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg">プロフィールを編集</h3>
    <form @submit.prevent="updateProfile">
          <input type="hidden" name="_token">
          <div>
            <span>名前</span>
            <input type="text" name="name" v-model="name">
          </div>
          <div>
            <span>プロフィール</span>
            <textarea name="profile" v-model="profile"></textarea>
          </div>
          <input type="submit" value="保存" class="bg-black text-white px-4 py-2 border rounded cursor-pointer" >
          
    </form>
  </div>
  <form method="dialog" class="modal-backdrop">
    <button>close</button>
  </form>
</dialog>
  </main>
</template>