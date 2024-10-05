import styles from '@/assets/css/cssModule_1.module.css'
import { useNavigate } from "react-router-dom";


function PageNotFound() {
	return (
    <>
    <div className={styles.box}>
      <h1>404</h1>
      {/* Параметр с именем * будет в объекте params как wildcard */}
      <p>Страница не найдена</p>
    </div>
    </>
	);
}

export default PageNotFound;
