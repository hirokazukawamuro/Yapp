<script setup lang="ts">
import { ref } from 'vue';
import axios from 'axios';
import { RouterLink, RouterView } from 'vue-router';

const message = ref('');

const send = () => {
  if (message.value.length !== 0) {
    axios
      .post('/send', {
        post: message.value,
      })
      .then((response) => {
        message.value = '';
      });
  }
}
</script>
<template>
  <div class="parent">
    <div class="menu bg-w-56 w-56 rounded-box">
      <router-link to="/v/home" class="btn btn-ghost"><img src="../../img/home.svg">ホーム</router-link>
      <router-link to="/v/search" class="btn btn-ghost"><img src="../../img/search.svg">検索</router-link>
      <router-link to="/v/profile" class="btn btn-ghost"><img src="../../img/profile.svg">プロフィール</router-link>
      <router-link to="/v/weather" class="btn btn-ghost"><img src="../../img/weather.svg">天気</router-link>
  
      <button class="btn btn-ghost bg-pink" onclick="my_modal_2.showModal()">ポスト</button>
        <dialog id="my_modal_2" class="modal">
          <div class="modal-box">
            <input type="text" name="message" placeholder="いいたいことはあるか？" v-model="message" class="input" @keyup.enter="send">
            <button class="sendbutton btn btn-ghost bg-pink" @click="send"> ポスト</button>
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
    <a href="https://projects.breezegroup.jp/"><p>チャットアプリ、始めてみませんか</p><img src="../../img/chat.png" alt="chat_view" class="w-30 h-20 "></a>
    
    </div>
</div>
</template>
<style>
.parent{
  display: flex;
    flex-wrap: wrap;
}
.content{
  border-left: 1px solid rgb(246, 169, 233);
  border-right: 1px solid rgb(246, 169, 233);
  width: 30%;
  height: 1000px;
}
router-link{
  text-align: left;
}
.menu{
  display: flex;
  flex-direction: column;
  width:calc( 100% /6);
}
.adv{
  margin-left: 100px;
}

</style>