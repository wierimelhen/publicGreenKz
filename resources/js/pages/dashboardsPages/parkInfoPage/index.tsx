import React from 'react';
import { useParams } from 'react-router-dom';
import styles from '@/assets/css/cssModule_1.module.css'

function ParkInfoPage() {
  const params = useParams();  // Захватывает параметры из URL

  return (
    <div className={styles.box}>
      <h1>Info Page</h1>
      {/* Параметр с именем * будет в объекте params как wildcard */}
      <p>Path after /info/: {params['*']}</p>
    </div>
  );
}

export default ParkInfoPage;