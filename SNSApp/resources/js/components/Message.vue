
<style>
.message {
    border: double 4px #ccc;
    margin: 0px;
    background-color: #fafafa;
}

.msg_title {
    margin: 0px 20px;
    color: #999;
    font-size: 16pt;
    font-weight: bold;
}

.msg_content {
    margin: 0px 20px;
    color: #aaa;
    font-size: 12pt;
}
</style>
<template>
    <div class="message">
        <p class="msg_title">{{  title  }}</p>
        <p class="msg_content">{{  content  }}</p>
    </div>
</template>
<script>

export default {
    props: {
        title: String,
        content: String,
    },
    data() {
        return {
        };
    },
    created() {
    },
    methods: {

    }
}

</script>