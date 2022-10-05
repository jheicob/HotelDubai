
const dateFormat = (fecha) => {
    console.log(fecha);
    let date = new Date(fecha);
    let month = date.getMonth() < 10 ? `0${date.getMonth()}` : date.getMonth();
    let day   = date.getDate()  < 10 ? `0${date.getDate()}`  : date.getDate();
    return `${day}/${month}`
}

const getDateFormat = (fecha) => {
    let [day,month] = fecha.split('/')
    let year = new Date().getFullYear()
    return `${year}-${month}-${day}`
}

export {
    dateFormat,
    getDateFormat
}
