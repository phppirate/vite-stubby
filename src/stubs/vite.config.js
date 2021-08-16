import vue from '@vitejs/plugin-vue'

export default ({ command }) => ({
    base: command === 'serve' ? '' : '/build/',
    publicDir: 'fake_dir_so_nothing_gets_copied',
    resolve: {
        alias: {
            '@models': '/resources/js/models',
            '@store': '/resources/js/store',
            '@components': '/resources/js/components',
            '@views': '/resources/js/views',
        },
    },
    build: {
        manifest: true,
        outDir: 'public/build',
        rollupOptions: {
            input: 'resources/js/app.ts',
        },
    },
    plugins: [vue()],
})
