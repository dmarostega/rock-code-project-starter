import { computed, ref } from 'vue';

type Theme = 'light' | 'dark';

const storageKey = 'rock-code-theme';
const theme = ref<Theme>('light');
const isBrowser = typeof window !== 'undefined' && typeof document !== 'undefined';

const getSystemTheme = (): Theme =>
  isBrowser && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';

const getStoredTheme = (): Theme | null => {
  if (!isBrowser) return null;

  const storedTheme = window.localStorage.getItem(storageKey);

  return storedTheme === 'light' || storedTheme === 'dark' ? storedTheme : null;
};

const applyTheme = (selectedTheme: Theme): void => {
  theme.value = selectedTheme;

  if (!isBrowser) return;

  document.documentElement.classList.toggle('dark', selectedTheme === 'dark');
  document.documentElement.style.colorScheme = selectedTheme;

  document
    .querySelector('meta[name="theme-color"]')
    ?.setAttribute('content', selectedTheme === 'dark' ? '#020617' : '#f8fafc');
};

export const initializeTheme = (): void => {
  applyTheme(getStoredTheme() ?? getSystemTheme());
};

export const useTheme = () => {
  const isDark = computed(() => theme.value === 'dark');

  const setTheme = (selectedTheme: Theme): void => {
    if (isBrowser) {
      window.localStorage.setItem(storageKey, selectedTheme);
    }

    applyTheme(selectedTheme);
  };

  const toggleTheme = (): void => {
    setTheme(isDark.value ? 'light' : 'dark');
  };

  return {
    isDark,
    theme,
    toggleTheme,
    setTheme,
  };
};
