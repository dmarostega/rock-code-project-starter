import axios from 'axios';

interface GrowthPayload {
  name: string;
  metadata?: Record<string, unknown>;
}

const storageKey = 'rockcode_anonymous_id';
const growthEnabled = import.meta.env.VITE_GROWTH_ENABLED === 'true';

function anonymousId(): string {
  let id = localStorage.getItem(storageKey);
  if (!id) {
    id = crypto.randomUUID();
    localStorage.setItem(storageKey, id);
  }
  return id;
}

export function useGrowth() {
  const track = async ({ name, metadata = {} }: GrowthPayload): Promise<void> => {
    if (!growthEnabled) {
      return;
    }

    try {
      await axios.post('/growth/events', {
        name,
        metadata,
        anonymous_id: anonymousId(),
        path: window.location.pathname,
        referrer: document.referrer || null,
      });
    } catch {
      // Tracking must never block the user flow.
    }
  };

  return { track };
}
