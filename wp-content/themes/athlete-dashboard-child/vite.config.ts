import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import path from 'path';
import fs from 'fs';

// Get all feature entry points
const getFeatureEntries = () => {
  const featuresDir = path.resolve(__dirname, 'features');
  const features = fs.readdirSync(featuresDir).filter(file => 
    fs.statSync(path.join(featuresDir, file)).isDirectory()
  );

  const entries: Record<string, string> = {
    // Dashboard core entry
    'dashboard/core': path.resolve(__dirname, 'dashboard/index.tsx'),
  };

  // Add feature entries
  features.forEach(feature => {
    const entryPath = path.resolve(featuresDir, feature, 'index.tsx');
    if (fs.existsSync(entryPath)) {
      entries[`features/${feature}`] = entryPath;
    }

    // Add feature-specific style entry if it exists
    const styleEntry = path.resolve(featuresDir, feature, 'assets/scss/styles.scss');
    if (fs.existsSync(styleEntry)) {
      entries[`features/${feature}/styles`] = styleEntry;
    }
  });

  return entries;
};

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [react()],
  build: {
    outDir: 'assets/dist',
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: getFeatureEntries(),
      output: {
        // Organize output files by feature
        entryFileNames: (chunkInfo) => {
          const name = chunkInfo.name;
          if (name.startsWith('dashboard/')) {
            return 'js/dashboard/[name].js';
          }
          return 'js/[name].js';
        },
        chunkFileNames: 'js/_chunks/[name]-[hash].js',
        assetFileNames: ({name}) => {
          if (/\.(css|scss)$/.test(name ?? '')) {
            // Handle CSS files
            if (name?.includes('dashboard/')) {
              return 'css/dashboard/[name].css';
            }
            return 'css/[name].css';
          }
          // Handle other assets
          return 'assets/[name]-[hash][extname]';
        }
      }
    }
  },
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'src'),
      '@dashboard': path.resolve(__dirname, 'dashboard'),
      '@features': path.resolve(__dirname, 'features'),
      '@components': path.resolve(__dirname, 'dashboard/components'),
      '@hooks': path.resolve(__dirname, 'dashboard/hooks'),
      '@utils': path.resolve(__dirname, 'dashboard/utils'),
      '@types': path.resolve(__dirname, 'dashboard/types'),
      '@events': path.resolve(__dirname, 'dashboard/events.ts'),
      '@assets': path.resolve(__dirname, 'assets'),
    }
  },
  css: {
    preprocessorOptions: {
      scss: {
        additionalData: `
          @import "@dashboard/styles/variables.scss";
          @import "@dashboard/styles/mixins.scss";
        `,
        importer(url: string) {
          // Handle feature-specific SCSS imports
          if (url.startsWith('@feature/')) {
            const [_, feature, ...rest] = url.split('/');
            return {
              file: path.resolve(__dirname, 'features', feature, 'assets/scss', rest.join('/'))
            };
          }
          return null;
        }
      }
    },
    modules: {
      localsConvention: 'camelCaseOnly'
    }
  },
  test: {
    globals: true,
    environment: 'jsdom',
    setupFiles: ['./vitest.setup.ts'],
    coverage: {
      reporter: ['text', 'json', 'html'],
      exclude: [
        'node_modules/',
        'dashboard/__tests__/',
        '**/types/',
        '**/*.d.ts',
      ]
    }
  },
  server: {
    port: 5173,
    strictPort: true,
    hmr: {
      port: 5173
    }
  }
}); 