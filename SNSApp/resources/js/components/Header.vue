<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/">{{ appname }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link active" href="/post/create">新規投稿</a>
                <a class="nav-item nav-link active" href="/user/follows">フォロー追加 <span class="sr-only"></span></a>
                <a class="nav-item nav-link active" href="/chat">チャット <span class="sr-only"></span></a>
                
                <a class="nav-item nav-link active" href="#" @click.prevent.stop="logout()">ログアウト</a>
            </div>
        </div>
    </nav>
</template>

<script>

export default {
    props: {
        appname: String,
    },
    created() {

    },
    methods: {
        logout() {
            let url = `/logout`
            axios.post(url)
                .then(Response => {
                    //リダイレクト
                    location.href = "/"
                })
                .catch(error => { alert(error) })
        }
    }
}

</script>