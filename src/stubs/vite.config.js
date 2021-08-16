import vue from '@vitejs/plugin-vue';

export default ({ command }) => ({
    base: command === 'serve' ? '' : '/build/',
    publicDir: false,
    build: {
        manifest: true,
        outDir: 'public/build',
        rollupOptions: {
            input: 'resources/ts/app.ts',
        },
    },
    plugins: [vue()],
});
