<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">{{appname}}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link active" href="#">タイムライン <span class="sr-only"></span></a>
                <a class="nav-item nav-link active" href="#">投稿</a>
                <a class="nav-item nav-link active" href="/logout">ログアウト</a>
            </div>
        </div>
    </nav>
</template>

<script>
    export default {
    props: {
        appname: String,
    },
}
</script>