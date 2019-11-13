import Http from './http'

export default {
    
    //EMPLOYEE AREA
    getallemployee(){
        return new Promise((resolve, reject) => {
            
            const successCallback = (res) => {
                const user = res.data
                resolve(res.data)
            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.get('/api/karyawan', successCallback, errorCallback)
        })
    },
    addemployee(payload) {
        return new Promise((resolve, reject) => {

            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.post('/api/karyawan', payload, successCallback, errorCallback)
        })
    },
    updateemployee(payload,id){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)

            }

            Http.patch('/api/karyawan/'+id, payload, successCallback, errorCallback)
        })
    },
    deleteemployee(id){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)

            }

            Http.delete('/api/karyawan/'+id, successCallback, errorCallback)
        })
    },

    //DIVISI AREA
    getalldivisirole(){
        return new Promise((resolve, reject) => {
            
            const successCallback = (res) => {
                const user = res.data
                resolve(res.data)
            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.get('/api/divisi', successCallback, errorCallback)
        })
    },
    adddivisi(payload) {
        return new Promise((resolve, reject) => {

            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.post('/api/divisi', payload, successCallback, errorCallback)
        })
    },
    updatedivisi(payload,id){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)

            }

            Http.patch('/api/divisi/'+id, payload, successCallback, errorCallback)
        })
    },
    deletedivisi(id){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)

            }

            Http.delete('/api/divisi/'+id, successCallback, errorCallback)
        })
    },


    //JABATAN AREA
    
    getalljabatan(){
        return new Promise((resolve, reject) => {
            
            const successCallback = (res) => {
                const user = res.data
                resolve(res.data)
            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.get('/api/jabatan', successCallback, errorCallback)
        })
    },
    addjabatan(payload) {
        return new Promise((resolve, reject) => {

            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.post('/api/jabatan', payload, successCallback, errorCallback)
        })
    },
    updatejabatan(payload,id){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)

            }

            Http.patch('/api/jabatan/'+id, payload, successCallback, errorCallback)
        })
    },
    deletejabatan(id){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)

            }

            Http.delete('/api/jabatan/'+id, successCallback, errorCallback)
        })
    },

    //PROJECT AREA
    getallproject(){
        return new Promise((resolve, reject) => {
            
            const successCallback = (res) => {
                const user = res.data
                resolve(res.data)
            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.get('/api/proyek', successCallback, errorCallback)
        })
    },

    //LOG PENGERJAAN
    getalllogpengerjaan(){
        return new Promise((resolve, reject) => {
            
            const successCallback = (res) => {
                const user = res.data
                resolve(res.data)
            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.get('/api/log_pengerjaan', successCallback, errorCallback)
        })
    },
    

    //AKSES
    getalljobakses(){
        return new Promise((resolve, reject) => {
            
            const successCallback = (res) => {
                const user = res.data
                resolve(res.data)
            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.get('/api/akses_pekerjaan', successCallback, errorCallback)
        })
    },

    addjobakses(payload) {
        return new Promise((resolve, reject) => {

            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.post('/api/akses_pekerjaan', payload, successCallback, errorCallback)
        })
    },

    updatejobakses(payload,id){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)

            }

            Http.patch('/api/akses_pekerjaan/'+id, payload, successCallback, errorCallback)
        })
    },

    deletejobakses(id){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)

            }

            Http.delete('/api/akses_pekerjaan/'+id, successCallback, errorCallback)
        })
    },


   


    



}