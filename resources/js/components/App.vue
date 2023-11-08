<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'

</script>
<template>
  <div class="parent">
    <div class="menu bg-w-56 w-56 rounded-box">
      <router-link to="/" class="btn btn-ghost"><img src="../../svg/home.svg">ホーム</router-link>
      <router-link to="/search" class="btn btn-ghost"><img src="../../svg/search.svg">検索</router-link>
      <router-link to="/profile" class="btn btn-ghost"><img src="../../svg/profile.svg">プロフィール</router-link>
      <router-link to="/weather" class="btn btn-ghost"><img src="../../svg/weather.svg">天気</router-link>
      <button class="btn btn-ghost bg-pink">ポスト</button>
    </div>
    <div class="divider"></div> 
    <div class="content">
      <RouterView />
    </div>
    <div class="adv">
    <a href="https://projects.breezegroup.jp/"><p>チャットアプリ、始めてみませんか</p><img src="../../svg/chat.png" alt="chat_view" class="w-30 h-20 "></a>
    
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