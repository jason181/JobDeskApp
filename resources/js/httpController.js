import Http from './http'

export default {
    //LOG SESI AREA
    getallsessionlog(){
        return new Promise((resolve, reject) => {
            
            const successCallback = (res) => {
                const user = res.data
                resolve(res.data)
            }

            const errorCallback = (err) => {
                reject(err)
            }

            Http.get('/api/log_sesi', successCallback, errorCallback)
        })
    },
    addsessionlog(payload) {
        return new Promise((resolve, reject) => {

            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.post('/api/log_sesi', payload, successCallback, errorCallback)
        })
    },
    

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
    //AKUN AREA
    getallakun(){
        return new Promise((resolve, reject) => {
            
            const successCallback = (res) => {
                const user = res.data
                resolve(res.data)
            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.get('/api/akun', successCallback, errorCallback)
        })
    },
    updateakun(payload,id){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)

            }

            Http.patch('/api/akun/'+id, payload, successCallback, errorCallback)
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
    getproject(){
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
    getallproject(){
        return new Promise((resolve, reject) => {
            
            const successCallback = (res) => {
                const user = res.data
                resolve(res.data)
            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.get('/api/proyek/all', successCallback, errorCallback)
        })
    },
    getoneproject(id){
        return new Promise((resolve, reject) => {
            
            const successCallback = (res) => {
                const user = res.data
                resolve(res.data)
            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.get('/api/proyek/'+id, successCallback, errorCallback)
        })
    },
    addproject(payload){
        return new Promise((resolve, reject) => {

            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.post('/api/proyek/add', payload, successCallback, errorCallback)
        })
    },
    updateproject(payload,id){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)

            }

            Http.patch('/api/proyek/update/'+id, payload, successCallback, errorCallback)
        })
    },
    deleteproject(id){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)
            }

            Http.delete('/api/proyek/'+id, successCallback, errorCallback)
        })
    },
    //DIVISI PROYEK
    adddivisiproyek(payload){
        return new Promise((resolve, reject) => {

            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)
    
            }
            Http.post('/api/divisi_proyek', payload, successCallback, errorCallback)
        })
    },
    deletedivisiproyek(id){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)
            }

            Http.delete('/api/divisi_proyek/'+id, successCallback, errorCallback)
        })
    },
    //SUB DIVISI PROYEK
    addsubdivisiproyek(payload){
        return new Promise((resolve, reject) => {

            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)
    
            }
            Http.post('/api/sub_divisi_proyek', payload, successCallback, errorCallback)
        })
    },
    deletesubdivisiproyek(id){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)
            }

            Http.delete('/api/sub_divisi_proyek/'+id, successCallback, errorCallback)
        })
    },
    //ITEM PEKERJAAN
    additempekerjaan(payload){
        return new Promise((resolve, reject) => {

            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)
    
            }
            Http.post('/api/item_pekerjaan', payload, successCallback, errorCallback)
        })
    },
    deleteitempekerjaan(id){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)
            }

            Http.delete('/api/item_pekerjaan/'+id, successCallback, errorCallback)
        })
    },
    //SUB ITEM PEKERJAAN
    // updatesubitempekerjaan(payload,id){
    //     return new Promise((resolve, reject) => {
    //         const successCallback = (res) => {
    //             const data = res.data
    //             resolve(data)

    //         }

    //         const errorCallback = (err) => {
    //             reject(err)

    //         }

    //         Http.patch('/api/log_pengerjaan/'+id, payload, successCallback, errorCallback)
    //     })
    // },
    deletesubitempekerjaan(id){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)
            }

            Http.delete('/api/sub_item_pekerjaan/'+id, successCallback, errorCallback)
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

    addlogpengerjaan(payload) {
        return new Promise((resolve, reject) => {

            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.post('/api/log_pengerjaan', payload, successCallback, errorCallback)
        })
    },

    updatelogpengerjaan(payload,id){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)

            }

            Http.patch('/api/log_pengerjaan/'+id, payload, successCallback, errorCallback)
        })
    },
    deletelogpengerjaan(id){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)
            }

            Http.delete('/api/log_pengerjaan/'+id, successCallback, errorCallback)
        })
    },
    uploadfile(payload){
        return new Promise((resolve, reject) => {

            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.post('/api/log_pengerjaan/storeFile', payload, successCallback, errorCallback)
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

    //Persentase
    getProgressProyek(id){
        return new Promise((resolve, reject) => {
            
            const successCallback = (res) => {
                const user = res.data
                resolve(res.data)
            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.get('/api/'+id+'/hitungProyek/', successCallback, errorCallback)
        })
    },
    getProgressDivisi(id){
        return new Promise((resolve, reject) => {
            
            const successCallback = (res) => {
                const user = res.data
                resolve(res.data)
            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.get('/api/hitungDivisi/'+id, successCallback, errorCallback)
        })
    },
    getProgressSubDivisi(id){
        return new Promise((resolve, reject) => {
            
            const successCallback = (res) => {
                const user = res.data
                resolve(res.data)
            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.get('/api/hitungSubDivisi/'+id, successCallback, errorCallback)
        })
    },
    getProgressItem(id){
        return new Promise((resolve, reject) => {
            
            const successCallback = (res) => {
                const user = res.data
                resolve(res.data)
            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.get('/api/hitungItem/'+id, successCallback, errorCallback)
        })
    },
    getProgressSubItem(id){
        return new Promise((resolve, reject) => {
            
            const successCallback = (res) => {
                const user = res.data
                resolve(res.data)
            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.get('/api/hitungSubItem/'+id, successCallback, errorCallback)
        })
    },

    //DASHBOARD AREA
    getdashboard(id){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const user = res.data
                resolve(res.data)
            }

            const errorCallback = (err) => {
                reject(err)
            }

            Http.get('/api/getProject/'+id, successCallback, errorCallback)
        })
    },


   


    



}