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

export interface PageProps {
  appName: string;
  auth: { user: User | null };
  flash: { success: string | null; error: string | null };
  seo: SeoData;
  [key: string]: unknown;
}

export interface MediaAsset {
  id: string;
  original_name: string;
  mime_type: string;
  size: number;
  url: string;
}
