export default function auth ({ next, store }){
    if(!store.state.user || store.state.user.type !== 'professor'){
        window.location.href = "/login"
    }

    return next()
}
