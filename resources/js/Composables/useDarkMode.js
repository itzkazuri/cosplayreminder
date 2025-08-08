import { ref, onMounted, watch } from 'vue';

const isDarkMode = ref(false);

export function useDarkMode() {
  const toggleDarkMode = () => {
    isDarkMode.value = !isDarkMode.value;
    localStorage.setItem('theme', isDarkMode.value ? 'dark' : 'light');
    applyDarkModeClass();
  };

  const applyDarkModeClass = () => {
    if (isDarkMode.value) {
      document.documentElement.classList.add('dark');
    } else {
      document.documentElement.classList.remove('dark');
    }
  };

  onMounted(() => {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
      isDarkMode.value = savedTheme === 'dark';
    } else {
      // Deteksi preferensi sistem
      isDarkMode.value = window.matchMedia('(prefers-color-scheme: dark)').matches;
    }
    applyDarkModeClass();
  });

  watch(isDarkMode, () => {
    applyDarkModeClass();
  });

  return { isDarkMode, toggleDarkMode };
}
