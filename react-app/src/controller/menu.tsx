import {useNavigate} from "react-router-dom";

const Menu = () => {
    let hasToken = localStorage.getItem('jwtToken') != null;
    let isAdmin = localStorage.getItem('isAdmin') != null;

    return (
        <>
            <a href='/'> Home </a>
            <a href='/login' hidden={hasToken}> Login </a>
            <a href='/admin/quiz' hidden={!isAdmin}> Quiz configs </a>
            <button onClick={() => {localStorage.clear(); window.location.href = '/'}} hidden={!hasToken}> Log out</button>
        </>
    );
}

export default Menu;
