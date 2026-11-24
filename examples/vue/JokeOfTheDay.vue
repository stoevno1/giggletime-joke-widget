<!-- Today's joke from GiggleTime. Usage: <JokeOfTheDay lang="de" /> -->
<script setup>
import { ref, watch } from 'vue';

const props = defineProps({ lang: { type: String, default: 'en' } });
const data = ref(null);
const revealed = ref(false);

watch(
  () => props.lang,
  async (lang) => {
    revealed.value = false;
    try {
      const response = await fetch(`https://www.giggletime.app/embed/today?lang=${encodeURIComponent(lang)}`);
      data.value = await response.json();
    } catch (e) {
      data.value = null;
    }
  },
  { immediate: true }
);
</script>

<template>
  <div v-if="data && data.joke" class="joke-of-the-day" :dir="data.joke.rtl ? 'rtl' : 'ltr'">
    <strong>{{ data.labels.title }}</strong>
    <template v-if="data.joke.setup && data.joke.punchline">
      <p>{{ data.joke.setup }}</p>
      <p v-if="revealed">{{ data.joke.punchline }}</p>
      <button v-else type="button" @click="revealed = true">{{ data.labels.reveal }}</button>
    </template>
    <p v-else>{{ data.joke.text }}</p>
    <p><small>Joke of the day by <a :href="data.joke.url">GiggleTime</a></small></p>
  </div>
</template>
