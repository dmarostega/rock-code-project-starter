export interface User {
  id: number;
  name: string;
  email: string;
}

export interface SeoData {
  title: string;
  description: string | null;
  image: string | null;
  canonical: string | null;
  robots: string;
  type: string;
  twitterCard: string;
}

export interface AppSettings {
  publicName: string;
  contact: {
    name: string | null;
    email: string | null;
    phone: string | null;
    url: string | null;
  };
  flags: {
    public_registration: boolean;
    media_uploads: boolean;
    growth_tracking: boolean;
  };
}

export interface PageProps {
  appName: string;
  appSettings: AppSettings;
  auth: { user: User | null };
  flash: { success: string | null; error: string | null };
  seo: SeoData;
  [key: string]: unknown;
}

export interface MediaAsset {
  id: string;
  kind: 'image' | 'document';
  mime_type: string;
  size: number;
  width: number | null;
  height: number | null;
  alt_text: string | null;
  display_name: string;
  url: string;
}
