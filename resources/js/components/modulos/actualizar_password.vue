<template>
    <div>
      <v-row
        style="font-family: 'Arial Black'; color: black"
        align="center"
        justify="center"
      >
        <v-col cols="12" sm="4" align="center" justify="center">
          <v-card
            color="transparent"
            rounded="xl"
            class="text-md-center"
            style="color: rgb(255, 212, 76)"
          >
            <v-card-title primary-title class="justify-center" style="line-height: 1em;">
              <h3>NUEVA CONTRASEÑA</h3>
              <span style="font-weight: bold; font-size: x-small; color: white">
                Hola ( {{ formRegistro.nombres }}), ingresa tu nueva contraseña.
            </span>
            </v-card-title>
  
            <v-card-text>
               
              
    
  
           
    
              <v-text-field
              type="password"
              v-model="formRegistro.Password"
              rounded
              background-color="#FFD44C"
              filled
              label="Crear Contraseña"
              required
            ></v-text-field>

            <v-text-field
              type="password"
              v-model="formRegistro.ConfirmPassword"
              rounded
              background-color="#FFD44C"
              filled
              label="Repetir Contraseña"
              required
            ></v-text-field>
            </v-card-text>
  
            <v-card-actions class="justify-center">
              <v-btn rounded color="#FFD44C" @click="GrabarRegistro()" >
                &nbsp;&nbsp;&nbsp; CAMBIAR CONTRASEÑA&nbsp;&nbsp;&nbsp;</v-btn
              >
            </v-card-actions>
          </v-card>
          <!-- <span
              >Para reservas mayores a 10 personas, por favor contáctarse al número
              xxxxxxxxxx.</span -->
        </v-col>
      </v-row>
  
      <!-- <dash-menu> </dash-menu> -->
    </div>
  </template>
    
    <script>
  export default {
    props: {
      user: {
        type: Object,
      },
      invert: {
        type: Object,
      },
    },
    name: "PageIndex",
    data() {
      return {
        ListaIdentificacion: [
          { id: "1", descripcion: "RUC" },
          { id: "2", descripcion: "CEDULA" },
        ],
        usuario:{
          idIdentificacion:0,
          identificacion:0,
          nombre:"",
          telefono:"",
          mail:"",
        },
        formRegistro: {
          idIdentificacion: 0,
          identificacion: 0,
          nombres: "",
          telefono: 0,
  
          mail: "",
          Password: "",
          ConfirmPassword: "",
          terminos: false,
        },
        rules: {
          age: [
            (val) =>
              val < 11 ||
              `Si la cantidad es mayor a 10 personas es obligatorio cancelar la reserva`,
          ],
        },
        nameRulesCedula: [
          (v) => !!v || "Campo es Requerido",
          (v) => (v && v.length <= 13) || "Campo minimo 10 caracteres",
        ],
        nameRulesTelefono: [],
        nameRules: [
          (v) => !!v || "Campo es Requerido",
          (v) => (v && v.length <= 25) || "Campo minimo 25 caracteres",
        ],
        ItemEstacion: 0,
        vtext: "",
        valuecarlos: "",
        valuejonu: "",
        form: {
          id: "",
        },
      };
    },
    components: {},
    mounted() {
      this.generar();
    },
    methods: {
      GrabarRegistro() {
      try {
       
        

        if (
          this.formRegistro.Password == "" ||
          this.formRegistro.Password == 0
        ) {
          this.$swal("Copedesa!!!", "Ingresar la Contraseña", "error");
          return;
        }
        if (
          this.formRegistro.ConfirmPassword == "" ||
          this.formRegistro.ConfirmPassword == 0
        ) {
          this.$swal("Copedesa!!!", "Ingresar la verificación", "error");
          return;
        }
 
        if (
          this.formRegistro.Password != this.formRegistro.ConfirmPassword
        ) {
          this.$swal("Copedesa!!!", "La contraseña no es la misma de la Verificación", "error");
          return;
        }
        
        


        let url =
          this.$store.getters.getRuta +
          "/modulos/sorteo/copedesa/PostActualizarPassword/";
       
        axios
          .post(url, this.formRegistro)
          .then((response) => {
            
              if (response.data.verificacion == true) {
                this.$swal("Copedesa!!!", response.data.mensaje, "warning");
                this.$router.push('/')
                
              }else{
                this.$swal("Copedesa!!!", response.data.mensaje, "error");
              }
         
            
          })
          .catch((error) => {
            this.mensajeAler(true, true);
            this.$swal("Copedesa!!!", error, "error");
            window.location.replace("/");

            
          });
      
        } catch (error) {}
    },
      generar() {
      try {
        console.log("usuario", this.$store.usuario);
        if (this.$store.usuario.length != 0) {
          this.formRegistro.idIdentificacion = this.$store.usuario.idIdentificacion;
          this.formRegistro.identificacion = this.$store.usuario.identificacion;
          this.formRegistro.nombres = this.$store.usuario.nombre;
          this.formRegistro.telefono = this.$store.usuario.telefono;
          this.formRegistro.mail = this.$store.usuario.mail;
          // this.usuario.idIdentificacion = this.$store.usuario.idIdentificacion;
          // this.usuario.identificacion = this.$store.usuario.identificacion;
          // this.usuario.nombre = this.$store.usuario.nombre;
          // this.usuario.telefono = this.$store.usuario.telefono;
          // this.usuario.mail = this.$store.usuario.mail;
          // this.ConsultaCodigos();
        } else {
          this.$router.push("/");
        }
      } catch (error) {
        this.$router.push("/");
      }
    },
      ValidarCedula() {
        try {
          if (
            this.formRegistro.identificacion.length == 10 ||
            this.formRegistro.identificacion.length == 13
          ) {
            let url =
              this.$store.getters.getRuta +
              "/modulos/sorteo/copedesa/consulta_usuario/" +
              this.formRegistro.identificacion;
  
            axios
              .get(url)
              .then((response) => {
                if (response.data.data == null) {
                  this.$swal(
                    "Copedesa!!!",
                    "El numero de identificación no se encuentra en nuestras base, tanquea para ser parte del sorte o intenta mas tarde",
                    "info"
                  );
                  return;
                }
                console.log("liusta", response.data);
              })
              .catch((error) => {
                //Errores de validación
              });
          }
        } catch (error) {}
      },
    
      showAlert() {
        // Use sweetalert2
        // this.$swal('Hello Vue world!!!',confirmButtonColor);
        this.$swal("Hello Vue world!!!", "codigo 2", "error");
        //       this.$swal.fire({
        //   title: 'Error!',
        //   text: 'Do you want to continue',
        //   icon: 'error',
        //   confirmButtonText: 'Cool'
        // })
      },
      saludar() {},
    },
  };
  </script>
     