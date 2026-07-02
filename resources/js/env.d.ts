/// <reference types="vite/client" />

interface ImportMetaEnv {
  readonly VITE_APP_NAME: string;
  readonly VITE_GROWTH_ENABLED?: string;
}

interface ImportMeta {
  readonly env: ImportMetaEnv;
}
