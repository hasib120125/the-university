export default function guest({ next, store }) {
    const user = JSON.parse(localStorage.getItem('user'));
    if (user) {
        return next({
            name: 'home'
        })
    }

    return next()
}
