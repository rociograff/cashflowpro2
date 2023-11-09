import {Link} from 'react-router-dom'

export const Sesion = () => {
    return (
      <>
        <div className="iconoSesion">
          <Link className="nav-link homecito" to={"/register"}>
            Registro
          </Link>
          <Link className="nav-link homecito m-4" to={"/login"}>
            Iniciar Sesión
          </Link>
          {/* <Link className="nav-link homecito m-4" to={"/signin"}>
            Iniciar con Google
          </Link> */}
        </div>
      </>
    );
}
export default Sesion;