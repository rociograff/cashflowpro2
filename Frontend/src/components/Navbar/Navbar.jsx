import { LogoTitle } from "./LogoTitle/LogoTitle"
import { Sesion } from "./Sesion/Sesion"
import './NavbarPublico.css'
import { Link } from "react-router-dom"
/*import { useEffect,useState } from "react"*/
import axios from "axios"
import { CategoriasNavbar } from "./CategoriasNavbar/CategoriasNavbar"
import { SesionIniciada } from "./SesionIniciada/SesionIniciada"
import CambioColor from "../CambioColor/CambioColor"
import { useState, useEffect } from "react"


export const Navbar = () => {

  const [loggedIn, setLoggedIn] = useState();

  //para saber si hay un token/sesion iniciada y asi renderizar el componente correspondiente 
  // let sesionIniciada
  // if (localStorage.getItem('auth_token')) {
  //   sesionIniciada = true;
  // } else {
  //   sesionIniciada = false;
  // }

  useEffect(() => {
    if (localStorage.getItem("auth_token")) {
      setLoggedIn(true);
    } else {
      setLoggedIn(false);
    }
  }, []);


  //PARA PONER EL COLOR QUE HAY REGISTRADO EN EL LOCALSTORAGE SEGUN LA BASE DE DATOS

  const misColores = CambioColor();


  //para saber el color que tiene declarado en la base de datos


  return (
    <nav className="navbar navbar-expand-lg navbar-dark" style={{ color: misColores.color, backgroundColor: misColores.backgroundColor }}>
      <div className="container-fluid" style={{ color: misColores.color, backgroundColor: misColores.backgroundColor }}>
        <Link className="navbar-brand" to={'/'}>
          <LogoTitle />
        </Link>
        {loggedIn ? (
          <>
            <div className="collapse navbar-collapse" id="navbarColor01">
              <CategoriasNavbar />
            </div>

            <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
              <span className="navbar-toggler-icon" />
            </button>
            <div className="sesion">
              {loggedIn ? <SesionIniciada nombre={localStorage.getItem('nombre')} /> : <Sesion />}
            </div>
          </>
        ) : (

          <div className="sesion">
            {loggedIn ? <SesionIniciada nombre={localStorage.getItem('nombre')} /> : <Sesion />}
          </div>

        )}
      </div>
    </nav>
  );


}

