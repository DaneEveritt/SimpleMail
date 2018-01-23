<template>
    <div>
        <message-sent/>
        <message-error/>
        <div class="flex mb-2">
            <div class="w-full h-12">
                <send-message/>
            </div>
        </div>
    </div>
</template>

<script>
    import MessageSent from './components/MessageSent.vue'
    import MessageError from './components/MessageError.vue'
    import SendMessage from './components/SendMessage.vue'

    export default {
        name: 'app',
        components: {
            MessageSent,
            MessageError,
            SendMessage,
        },
    }
</script>
