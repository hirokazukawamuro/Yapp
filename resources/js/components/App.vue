<script setup lang="ts">
import { ref } from "vue";
import axios from "axios";
import { RouterLink, RouterView } from "vue-router";

const message = ref("");
const image = ref("");

const send = () => {
  if (message.value.length !== 0) {
    // Include the image data in the FormData
    const formData = new FormData();
    formData.append("post", message.value);
    formData.append("image", image.value);

    axios
      .post("/send", formData)
      .then((response) => {
        message.value = "";
        image.value = null;
      })
      .catch((error) => {
        console.error("Error sending post:", error);
      });
  }
};
const fileSelected = (event) => {
  image.value = event.target.files[0];
  console.log("Selected image:", image.value);
};
</script>
<template>
  <div class="parent">
    <div class="menu bg-w-56 w-56 rounded-box">
      <router-link to="/v/home" class="btn btn-ghost"><img src="../../img/aicon-1.png" class="sidebar" /></router-link>
      <router-link to="/v/home" class="btn btn-ghost"><img src="../../img/home.svg" class="sidebar" />ホーム</router-link>
      <router-link to="/v/search" class="btn btn-ghost"><img src="../../img/search.svg" class="sidebar" />検索</router-link>
      <router-link to="/v/profile" class="btn btn-ghost"><img src="../../img/profile.svg"
          class="sidebar" />プロフィール</router-link>
      <router-link to="/v/weather" class="btn btn-ghost"><img src="../../img/weather.svg"
          class="sidebar" />天気</router-link>

      <button class="btn btn-ghost bg-pink" onclick="my_modal_2.showModal()">
        ポスト
      </button>

      <a href="/">ログインユーザの名前とアイコン(ログアウト)</a>
      <dialog id="my_modal_2" class="modal">
        <div class="modal-box">
          <input type="text" name="message" placeholder="いいたいことはあるか？" v-model="message" class="input"
            @keyup.enter="send" />
          <input type="file" name="image" accept="image/*" @change="fileSelected" />
          <button class="sendbutton btn btn-ghost bg-pink" @click="send">ポスト</button>
        </div>
        <form method="dialog" class="modal-backdrop">
          <button>close</button>
        </form>
      </dialog>
    </div>
    <div class="divider"></div>
    <div class="content">
      <RouterView />
    </div>
    <div class="adv">
      <a href="https://projects.breezegroup.jp/">
        <p>チャットアプリ、始めてみませんか</p>
        <img src="../../img/chat.png" alt="chat_view" class="w-30 h-20" />
      </a>
    </div>
  </div>
</template>
<style>
.sidebar {
  width: 50px;
  height: 50px;
}

.parent {
  display: flex;
  flex-wrap: wrap;
}

.content {
  border-left: 1px solid rgb(246, 169, 233);
  border-right: 1px solid rgb(246, 169, 233);
  width: 30%;
  height: 1000px;
}

router-link {
  text-align: left;
}

.menu {
  display: flex;
  flex-direction: column;
  width: calc(100% / 6);
}

.adv {
  margin-left: 100px;
}
</style>
