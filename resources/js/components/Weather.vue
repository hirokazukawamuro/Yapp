<script setup lang="ts">
import { ref } from "vue";
import axios from "axios";

const weather = ref<WeatherData>({
  latitude: 0,
  longitude: 0,
  generationtime_ms: 0,
  utc_offset_seconds: 0,
  timezone_abbreviation: "",
  elevation: 0,
  hourly_units: {
    time: "",
    temperature_2m: "",
  },
  hourly: {
    time: [],
    temperature_2m: [],
  },
  daily_units: {
    time: [],
    weather_code: [],
  },
  daily: {
    time: [],
    weather_code: [],
  },
});
const latitude = ref<number | null>(null);
const longitude = ref<number | null>(null);

interface WeatherData {
  latitude: number;
  longitude: number;
  generationtime_ms: number;
  utc_offset_seconds: number;
  timezone_abbreviation: string;
  elevation: number;
  hourly_units: {
    time: string;
    temperature_2m: string;
  };
  hourly: {
    time: string[];
    temperature_2m: number[];
  };
  daily_units: {
    time: string[];
    weather_code: number[];
  };
  daily: {
    time: string[];
    weather_code: number[];
  };
}

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
    <h1>東京の 1 時間ごとの気温</h1>
    <div v-if="weather.hourly">
      <ul>
        <li v-for="(temperature, index) in weather.hourly.temperature_2m" :key="index">
          {{ index }}: {{ temperature }}°C
        </li>
      </ul>
    </div>

    <h1>東京の 1週間ごとの天気</h1>
    <div v-if="weather.daily">
      <ul>
        <li v-for="(weatherCode, index) in weather.daily.weather_code" :key="index">
          {{ index }}: {{ weatherCode }}
        </li>
      </ul>
    </div>
  </main>
</template>
