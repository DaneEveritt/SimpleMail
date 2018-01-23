<template>
    <div>
        <message-sent/>
        <message-error/>
        <div class="flex mb-2">
            <div class="w-full h-12">
                <tabs :options="{ useUrlFragment: true }">
                    <tab name="Send Message">
                        <send-message/>
                    </tab>
                    <tab name="About">
                        <about-page :version="version"/>
                    </tab>
                </tabs>
            </div>
        </div>
    </div>
</template>

<script>
    import MessageSent from './components/MessageSent.vue'
    import MessageError from './components/MessageError.vue'
    import SendMessage from './components/SendMessage.vue'
    import AboutPage from "./components/AboutPage";

    export default {
        name: 'app',
        props: ['version'],
        components: {
            AboutPage,
            MessageSent,
            MessageError,
            SendMessage,
        },
    }
</script>
