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
// const latitude = ref<number | null>(null);
// const longitude = ref<number | null>(null);
const selectedPrefecture = ref("");

const prefectures = [
  { name: "北海道", latitude: 43.0621, longitude: 141.3544 },
  { name: "青森県", latitude: 40.8222, longitude: 140.7474 },
  { name: "岩手県", latitude: 39.7036, longitude: 141.1525 },
  { name: "宮城県", latitude: 38.2689, longitude: 140.8719 },
  { name: "秋田県", latitude: 39.7186, longitude: 140.1024 },
  { name: "山形県", latitude: 38.2554, longitude: 140.3397 },
  { name: "福島県", latitude: 37.7609, longitude: 140.4731 },
  { name: "茨城県", latitude: 36.3416, longitude: 140.4468 },
  { name: "栃木県", latitude: 36.5658, longitude: 139.8836 },
  { name: "群馬県", latitude: 36.3912, longitude: 139.0609 },
  { name: "埼玉県", latitude: 35.8617, longitude: 139.6455 },
  { name: "千葉県", latitude: 35.6073, longitude: 140.106 },
  { name: "東京都", latitude: 35.6895, longitude: 139.6917 },
  { name: "神奈川県", latitude: 35.4437, longitude: 139.638 },
  { name: "新潟県", latitude: 37.9169, longitude: 139.0614 },
  { name: "富山県", latitude: 36.6959, longitude: 137.2137 },
  { name: "石川県", latitude: 36.5613, longitude: 136.6562 },
  { name: "福井県", latitude: 36.0652, longitude: 136.2215 },
  { name: "山梨県", latitude: 35.6628, longitude: 138.5683 },
  { name: "長野県", latitude: 36.6486, longitude: 138.1948 },
  { name: "岐阜県", latitude: 35.4224, longitude: 136.7606 },
  { name: "静岡県", latitude: 34.9769, longitude: 138.3831 },
  { name: "愛知県", latitude: 35.1815, longitude: 136.9066 },
  { name: "三重県", latitude: 34.7181, longitude: 136.5139 },
  { name: "滋賀県", latitude: 35.0044, longitude: 135.8683 },
  { name: "京都府", latitude: 35.0116, longitude: 135.7681 },
  { name: "大阪府", latitude: 34.6937, longitude: 135.5023 },
  { name: "兵庫県", latitude: 34.6913, longitude: 135.183 },
  { name: "奈良県", latitude: 34.6853, longitude: 135.8328 },
  { name: "和歌山県", latitude: 34.2305, longitude: 135.1706 },
  { name: "鳥取県", latitude: 35.5039, longitude: 134.2372 },
  { name: "島根県", latitude: 35.4722, longitude: 133.0508 },
  { name: "岡山県", latitude: 34.6618, longitude: 133.935 },
  { name: "広島県", latitude: 34.3853, longitude: 132.4553 },
  { name: "山口県", latitude: 34.1785, longitude: 131.4738 },
  { name: "徳島県", latitude: 34.0704, longitude: 134.5541 },
  { name: "香川県", latitude: 34.3401, longitude: 134.0438 },
  { name: "愛媛県", latitude: 33.8392, longitude: 132.7656 },
  { name: "高知県", latitude: 33.5597, longitude: 133.5311 },
  { name: "福岡県", latitude: 33.5903, longitude: 130.4019 },
  { name: "佐賀県", latitude: 33.2494, longitude: 130.2989 },
  { name: "長崎県", latitude: 32.7503, longitude: 129.877 },
  { name: "熊本県", latitude: 32.7898, longitude: 130.7417 },
  { name: "大分県", latitude: 33.2382, longitude: 131.6126 },
  { name: "宮崎県", latitude: 31.9076, longitude: 131.4201 },
  { name: "鹿児島県", latitude: 31.5602, longitude: 130.5581 },
  { name: "沖縄県", latitude: 26.2124, longitude: 127.6809 },
];

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
  const selectedPrefectureData = prefectures.find(
    (prefecture) => prefecture.name === selectedPrefecture.value
  );
  if (!selectedPrefectureData) return;
  axios
    .get(
      `https://api.open-meteo.com/v1/forecast?latitude=${selectedPrefectureData.latitude}&longitude=${selectedPrefectureData.longitude}&hourly=temperature_2m&daily=weather_code&timezone=Asia%2FTokyo`
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
    <select v-model="selectedPrefecture">
      <option value="">都道府県を選択してください</option>
      <option value="北海道">北海道</option>
      <option value="青森県">青森県</option>
      <option value="岩手県">岩手県</option>
      <option value="宮城県">宮城県</option>
      <option value="秋田県">秋田県</option>
      <option value="山形県">山形県</option>
      <option value="福島県">福島県</option>
      <option value="茨城県">茨城県</option>
      <option value="栃木県">栃木県</option>
      <option value="群馬県">群馬県</option>
      <option value="埼玉県">埼玉県</option>
      <option value="千葉県">千葉県</option>
      <option value="東京都">東京都</option>
      <option value="神奈川県">神奈川県</option>
      <option value="新潟県">新潟県</option>
      <option value="富山県">富山県</option>
      <option value="石川県">石川県</option>
      <option value="福井県">福井県</option>
      <option value="山梨県">山梨県</option>
      <option value="長野県">長野県</option>
      <option value="岐阜県">岐阜県</option>
      <option value="静岡県">静岡県</option>
      <option value="愛知県">愛知県</option>
      <option value="三重県">三重県</option>
      <option value="滋賀県">滋賀県</option>
      <option value="京都府">京都府</option>
      <option value="大阪府">大阪府</option>
      <option value="兵庫県">兵庫県</option>
      <option value="奈良県">奈良県</option>
      <option value="和歌山県">和歌山県</option>
      <option value="鳥取県">鳥取県</option>
      <option value="島根県">島根県</option>
      <option value="岡山県">岡山県</option>
      <option value="広島県">広島県</option>
      <option value="山口県">山口県</option>
      <option value="徳島県">徳島県</option>
      <option value="香川県">香川県</option>
      <option value="愛媛県">愛媛県</option>
      <option value="高知県">高知県</option>
      <option value="福岡県">福岡県</option>
      <option value="佐賀県">佐賀県</option>
      <option value="長崎県">長崎県</option>
      <option value="熊本県">熊本県</option>
      <option value="大分県">大分県</option>
      <option value="宮崎県">宮崎県</option>
      <option value="鹿児島県">鹿児島県</option>
      <option value="沖縄県">沖縄県</option>
    </select>

    <button @click="getWeather">天気を取得する</button>
    <h1>{{ selectedPrefecture }}の 1 時間ごとの気温</h1>
    <div v-if="weather.hourly">
      <ul>
        <li v-for="(temperature, index) in weather.hourly.temperature_2m" :key="index">
          {{ index }}: {{ temperature }}°C
        </li>
      </ul>
    </div>

    <h1>{{ selectedPrefecture }}の 1週間ごとの天気</h1>
    <div v-if="weather.daily">
      <ul>
        <li v-for="(weatherCode, index) in weather.daily.weather_code" :key="index">
          {{ index }}: {{ weatherCode }}
        </li>
      </ul>
    </div>
  </main>
</template>
