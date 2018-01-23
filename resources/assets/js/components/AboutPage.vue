<template>
    <div class="bg-white shadow-md rounded px-6 pt-6 pb-8 mb-4">
        <div class="max-w-lg bg-grey-lighter rounded shadow">
            <div class="px-6 py-4">
                <div class="font-bold text-xl mb-2">Version</div>
                <p class="text-grey-darker text-base">
                    This application is currently running version <code>{{ version }}</code>.
                </p>
            </div>
        </div>
        <div class="mt-4 max-w-lg bg-grey-lighter rounded shadow">
            <div class="px-6 py-4">
                <div class="font-bold text-xl mb-2">Author</div>
                <p class="text-grey-darker text-base">
                    Dane Everitt &mdash; dane@daneeveritt.com
                </p>
            </div>
        </div>
        <!--<div class="flex items-center">-->
            <!--<p class="text-grey-darker"><span class="font-bold">Version</span>: {{ version }}</p>-->
            <!--<p class="text-grey-darker"><span class="font-bold">Author</span>: Dane Everitt</p>-->
        <!--</div>-->
    </div>
</template>

<script>
    export default {
        name: 'about-page',
        props: ['version'],
    }
</script>
