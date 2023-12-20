<script setup lang="ts">
import { ref } from "vue";
import axios from "axios";

const weather = ref([]);
const latitude = ref<number | null>(null);
const longitude = ref<number | null>(null);

const getWeather = () => {
  axios
    .get(
      `https://api.open-meteo.com/v1/forecast?latitude=${latitude.value}&longitude=${longitude.value}&hourly=temperature_2m&daily=weather_code&timezone=Asia%2FTokyo`
    )
    .then((response) => {
      console.log(response.data);

      weather.value = response.data;
    })
    .catch((error) => {
      console.error("Error fetching weather:", error.response.data);
    });
};
</script>

<template>
  <main>
    <input v-model="latitude" type="text" id="latitude" placeholder="緯度" />
    <input v-model="longitude" type="text" id="longitude" placeholder="経度" />
    <button @click="getWeather">Get Weather</button>
    <h1>東京の 1 時間ごとの天気</h1>

    <h1>東京の 1週間ごとの天気</h1>
    <div v-if="weather">
      <p>{{ weather }}</p>
    </div>
  </main>
</template>
