import React from 'react';
import api from "@/api/api";
import { useParams } from 'react-router-dom';
import styles from '@/assets/css/cssModule_1.module.css'
import { useNavigate } from "react-router-dom";

function ParkInfoPage() {
  const params = useParams();  // Захватывает параметры из URL
    const navigate = useNavigate();

  const getDataPark = async () => {

    let formData = new FormData();
    formData.append("token", params['*'] ? params['*'].toString() : '');

    const resp = await api.getDataPark(formData);
    console.log(resp)

    if (resp.error) {
      navigate('/404/qr-code')
    }
};

    React.useEffect(() => {
        getDataPark()
    }, []);

  return (
    <>
    <div className={styles.box}>
      <h1>Info Page</h1>
      {/* Параметр с именем * будет в объекте params как wildcard */}
      <p>Path after /info/: {params['*']}</p>
    </div>
    <div className={styles.box}>
      <h3>Деревьев в парке:</h3>
      <h3>Больше всего:</h3>
      <h3>Самое старое дерево:</h3>
      <h3>Самое молодое дерево:</h3>
    </div>
    <div className={styles.box}>
      <h3>Организаций обслуживания:</h3>
    </div>
    </>

  );
}


export default ParkInfoPage;

