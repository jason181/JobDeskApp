<template>
    <v-container>
        <v-toolbar flat>
          <v-toolbar-title class="white--text">Job Access Request</v-toolbar-title>
          <v-divider
              class="mx-2 white"
              inset
              vertical
          ></v-divider>

          <!-- dialog box delete -->
          <v-dialog v-model="delDialog" max-width="500px">
            <v-card>
              <v-card-title>
                <span class="headline">Delete Item</span>
              </v-card-title>
              <v-card-text>
                <h3 class="text-sm-center">Are you sure want to delete this ?</h3>
              </v-card-text>
              <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" flat @click="deleteJobAkses()">Yes</v-btn>
                  <v-btn color="blue darken-1" flat @click="close">No</v-btn>
                  <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>          

          <!-- Search -->
          <v-spacer></v-spacer>
          <v-flex xs4 sm4 md4>
            <v-text-field 
                v-model="search"
                append-icon="search"
                label="Cari"
                single-line
                hide-details>
            </v-text-field>
          </v-flex>

        </v-toolbar>

        <!-- Tabel -->
        <v-data-table
          :headers="headers"
          :items="initialize"
          :search="search"
          class="elevation-1">
          <template v-slot:items="props">
              <td>{{ props.item.Nama_Pegawai }}</td>
              <td class="text-xs-left">
                  {{ props.item.Project }} > {{ props.item.Divisi }} > {{ props.item.Sub_Divisi }} > {{ props.item.Task }} > {{ props.item.Sub_Task }}
              </td>              
              <td class="text-xs-center">{{ props.item.Datetime_Request }}</td>
              <td class="text-xs-center">{{ props.item.Status }}</td>
              <td class="text-xs-center"> 
                   <v-btn v-if="props.item.Verifikasi=='Verified'"
                    depressed small color="success" dark 
                    style="text-transform:none !important;"
                    :disabled="Access('M-JobAccess-U')!=true"
                    @click="Unverified(props.item)">
                    Verified
                  </v-btn>
                  <v-btn v-else
                    depressed small color="error" dark 
                    style="text-transform:none !important;"
                    :disabled="Access('M-JobAccess-U')!=true"
                    @click="Verified(props.item)">
                    Unverified
                  </v-btn>
              </td>
              <td class="justify-center layout px-0">
              <v-icon
                  v-if="Access('M-JobAccess-D')==true"
                  small
                  @click="deleteItem(props.item)"
              >
                  delete
              </v-icon>
              </td>
          </template>
          <v-alert v-slot:no-results :value="true" color="error" icon="warning">
              Your search for "{{ search }}" found no results.
          </v-alert>
          <!-- <template v-slot:no-data>
              <v-btn color="primary" @click="initialize">Reset</v-btn>
          </template> -->
        </v-data-table>

        <!-- Alert -->
        <v-snackbar right bottom :color="alert.type"  value="true" v-if="alert.type">
          <v-icon>{{alert.icon}}</v-icon>{{alert.message}}
        </v-snackbar>
    </v-container>
</template>


<script>
  import Controller from '../httpController'
  import { mapGetters } from 'vuex'
//   import { mapState, mapActions } from 'vuex'
//   import userService from '../../service/User'

  export default {
    data: () => ({
      formDialog:false,
      delDialog: false,
      DateIn:false,
      search: '',
      i:0,
      headers: [
        { text: 'Nama Pegawai', align: 'left', value: 'Nama' },
        { text: 'Job (Project > Div > Sub Div > Task > Sub Task)', align: 'center', value: 'Divisi' },
        { text: 'Date Time Request', align: 'center', value: 'Datetime_Request'},
        { text: 'Status', align: 'center',value: 'Status' },
        { text: 'Verification', align: 'center',value: 'Verifikasi' },
        { text: 'Actions', align: 'center',value: 'name', sortable: false }
      ],
      jobAccess:[],
      jobAccessData: [],
      jobAccessDataFiltered:[],
      divisiData:[],
      jabatanData:[],
      editedIndex: -1,
      alert:{
        type: null,
        message: null,
        icon: null,
      },
      editedForm:{
        Id_Akses_Pekerjaan:'',
        Id_Sub_Item_Pekerjaan:'',
        Project:'',
        Divisi:'',
        Sub_Divisi:'',
        Task:'',
        Sub_Task:'',
        Id_Akun:'',
        Username:'',
        Nama_Pegawai:'',
        Status:'',
        Verifikasi:[]

      },
      editedFormDefault:{
        Id_Akses_Pekerjaan:'',
        Id_Sub_Item_Pekerjaan:'',
        Project:'',
        Divisi:'',
        Sub_Divisi:'',
        Task:'',
        Sub_Task:'',
        Id_Akun:'',
        Username:'',
        Nama_Pegawai:'',
        Status:'',
        Verifikasi:[]
      },
      PreviledgeAccess:[],
      FeatureAccess:[
        {Deskripsi:"Management Employee (Create)",Fitur:"M-Employee-C"},
        {Deskripsi:"Management Employee (Read)",Fitur:"M-Employee-R"},
        {Deskripsi:"Management Employee (Update)",Fitur:"M-Employee-U"},
        {Deskripsi:"Management Employee (Delete)",Fitur:"M-Employee-D"},
        {Deskripsi:"Management Role (Create)",Fitur:"M-Role-C"},
        {Deskripsi:"Management Role (Read)",Fitur:"M-Role-R"},
        {Deskripsi:"Management Role (Update)",Fitur:"M-Role-U"},
        {Deskripsi:"Management Role (Delete)",Fitur:"M-Role-D"},
      ]
    }),

    computed: {
      ...mapGetters({
            nama: 'LoggedUser/Name',
            jabatan: 'LoggedUser/Jabatan',
            divisi: 'LoggedUser/Divisi',
            akses:'LoggedUser/Akses',
        }),
      formTitle () {
        return this.editedIndex === -1 ? 'Add Employee' : 'Edit Employee'
      },
    //   ...mapState({
    //     loading: state => state.User.loading,
    //     error: state => state.User.error,
    //     users: state => state.User.users,
    //   }),
      initialize () {
        // this.employeeData = this.employee.filter(obj => obj.role != "Admin");
        // return this.userData
        this.jobAccessData = this.jobAccess.slice().reverse()
        return this.jobAccessData
      },


    },

    watch: {
      dialog (val) {
        val || this.close()
      },
      delDialog (val) {
        val || this.close()
      }
    },

    mounted () {
      this.loaddata ()
    //   this.getEmployee()
      // this.userfiltered()
    
    },

    methods: {
    //   ...mapActions({
    //       getEmployee: 'Employee/get',
    //       deleteEmployee: 'Employee/delete',
          
    //   }),
      async loaddata () {
        try {
            const data = (await Controller.getalljobakses()).data
            // this.employeeData = data.filter(obj => obj.Divisi != "Admin");
            this.jobAccess = data



        } catch (err) {
            console.log(err)
        }
      },
      async deleteJobAkses(){
        try {
            var id = this.jobAccessData[this.editedIndex].Id_Akses_Pekerjaan
            // var id = data.Id_Akses_Pekerjaan
            const response = await Controller.deletejobakses(id)
            console.log(response)
            await this.loaddata()
            this.close()
            this.showAlert('success','Sukses Hapus Data')

        } catch (err) {
            console.log(err)
            this.showAlert('success','Gagal Hapus Data')

        }
      },
      async Verified (data) {
        try {
  
            let payload ={
                Verifikasi:'Verified'
            } 
            const response = await Controller.updatejobakses(payload,data.Id_Akses_Pekerjaan)
            console.log(response)
            // Object.assign(this.employeeData[this.editedIndex], this.editedForm)
            await this.loaddata()
            this.close()
            this.showAlert('success','Sukses Verifikasi')

        } catch (err) {
            console.log(err)
            this.showAlert('error','Gagal Verifikasi')
        }
      },
      async Unverified (data) {
        try {
            let payload ={
                Verifikasi:'Unverified'
            } 
            const response = await Controller.updatejobakses(payload,data.Id_Akses_Pekerjaan)
            console.log(response)
            // Object.assign(this.employeeData[this.editedIndex], this.editedForm)
            await this.loaddata()
            this.close()
            this.showAlert('success','Sukses Un-Verifikasi')

        } catch (err) {
            console.log(err)
            this.showAlert('error','Gagal Un-Verifikasi')
        }
      },
      createUsername(fullname){
        var username = fullname
        
        // username = username.replace(/\s/g,''); //remove space
        username = username.replace(/ .*/,'');
        // console.log(username);
        username = username.toLowerCase(); //to lowercase
        // console.log(username);
        username = username+Math.floor(Math.random()*100)
        console.log(username);

        return username;

      },
      remove (item) {
        this.editedForm.Akses.splice(this.editedForm.Akses.indexOf(item), 1)
        this.editedForm.Akses = [...this.editedForm.Akses]
      },
      Access(codeAccess){

        var x;
        for(x in this.akses.data){
            if (codeAccess.includes(this.akses.data[x].Fitur)) {
                return true
            } 
        }
        return false
            
      },
    //   closeFormDialog(){
    //     this.formDialog= false
    //     this.editedForm = Object.assign({}, this.defaultItem)
    //   },
    //   userfiltered(){
    //     // console.log(this.userData)
    //     this.userDataFiltered = this.userData.filter(item => console.log(item));
    //     // console.log(this.userDataFiltered);
    //   },
      editItem (item) {
        this.editedIndex = this.employeeData.indexOf(item)
        this.editedForm = Object.assign({}, item)
        this.editedForm.Akses = this.editedForm.Akses.data
        this.formDialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.jobAccessData.indexOf(item)
        var id = this.jobAccessData[this.editedIndex].Id_Akses_Pekerjaan
        console.log(id)
        this.delDialog =true
        // confirm('Are you sure you want to delete this item?') && this.userData.splice(this.editedIndex, 1)
        // confirm('Are you sure you want to delete this item?') && this.deleteuser()
      },

      close () {
        this.formDialog = false
        this.delDialog = false
        setTimeout(() => {
          this.editedForm = Object.assign({}, this.editedFormDefault)
          this.editedIndex = -1
        }, 300)
      },
      
      showAlert (type,alert_message) {

        if(type == 'success'){
          this.alert.icon = 'fas fa-check-circle'
        }
        else if(type == 'error'){
          this.alert.icon = 'fas fa-exclamation-circle'
        }

        this.alert.type = type
        this.alert.message = alert_message
        
        let timer = this.showAlert.timer
        if (timer) {
          clearTimeout(timer)
        }
        this.showAlert.timer = setTimeout(() => {
            this.alert.type = null
            this.alert.icon = null
            this.alert.message = null
        }, 3000)
        
      }
      
    }
  }
</script>
