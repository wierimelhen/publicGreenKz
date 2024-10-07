import React, { useRef,useState, useEffect, useMemo } from 'react';
import { Canvas } from '@react-three/fiber';
import { OrbitControls, Stats, useGLTF } from '@react-three/drei';
import * as THREE from 'three';
import { Matrix4 } from 'three';
import api from "@/api/api";

interface TreeData {
  id: number;
  x: number;
  y: number;
}

// Функция для загрузки данных о деревьях из API
const getXYDataTrees = async (): Promise<TreeData[]> => {
    let formData = new FormData();
    formData.append("park_id", '1');

    const response = await api.getXYDataTrees(formData);
    const data = await response.response;
    return data;
  };

// Загрузка модели дерева
const SuzanneModel = () => {
  const { nodes } = useGLTF('/scenes/tree/tree.gltf');
  
  // Получаем ствол и крону как отдельные меши
  const treeMesh = nodes.AM113_063_Tilia01 as THREE.Mesh;
  const croneMesh = nodes.AM113_063_Tilia01_1 as THREE.Mesh;

  return {
    treeGeometry: treeMesh.geometry,
    treeMaterial: treeMesh.material,
    croneGeometry: croneMesh.geometry,
    croneMaterial: croneMesh.material,
  };
};
// Интерфейс для пропсов компонента InstancedMesh
interface Props {
  trees: TreeData[]; // Передаем позиции деревьев
}


const InstancedMesh = ({ trees }: Props) => {
  const meshRef = useRef<THREE.InstancedMesh>(null);
  const croneRef = useRef<THREE.InstancedMesh>(null);

  const matrix = useMemo(() => new Matrix4(), []);

  const { treeGeometry, treeMaterial, croneGeometry, croneMaterial } = SuzanneModel();

  useEffect(() => {
    if (meshRef.current && croneRef.current && treeGeometry && croneGeometry) {
      trees.forEach((tree, index) => {
        const position = new THREE.Vector3(tree.x, 0, tree.y); // Используем x и y для позиционирования дерева
        const scale = new THREE.Vector3(1, 1, 1);
        const quaternion = new THREE.Quaternion();

        matrix.compose(position, quaternion, scale);
        meshRef.current?.setMatrixAt(index, matrix);
        croneRef.current?.setMatrixAt(index, matrix);
      });

      meshRef.current.instanceMatrix.needsUpdate = true;
      croneRef.current.instanceMatrix.needsUpdate = true;
    }
  }, [trees, treeGeometry, croneGeometry]);

  return (
    <>
      <instancedMesh ref={meshRef} args={[treeGeometry, treeMaterial, trees.length]} />
      <instancedMesh ref={croneRef} args={[croneGeometry, croneMaterial, trees.length]} />
    </>
  );
};

const Ground = () => {
  return (
    <mesh rotation={[-Math.PI / 2, 0, 0]} position={[0, 0, 0]}>
      <planeGeometry args={[1000, 1000]} /> 
      <meshBasicMaterial color="#5e9759" /> {/* Задаем цвет земли (зеленый, например) */}
    </mesh>
  );
};

const Scene = () => {
  const [trees, setTrees] = useState<TreeData[]>([]);

    useEffect(() => {
    const loadTrees = async () => {
      const data = await getXYDataTrees();
      setTrees(data);
    };

    loadTrees();
  }, []);

  return (
    <>
      <ambientLight intensity={0.5} />
      <pointLight position={[10, 10, 10]} />
      <InstancedMesh trees={trees}/>
      <Ground />
      <OrbitControls         
        autoRotate
        minPolarAngle={Math.PI / 3}  // Ограничиваем минимальный угол опускания (60 градусов)
        maxPolarAngle={Math.PI / 2.2} // Ограничиваем максимальный угол поднятия (примерно 82 градусов)
        maxDistance={500}  // Максимальное отдаление камеры
        minDistance={50}   // Минимальное приближение камеры
        enablePan={false} // Отключаем панорамирование
  />
    </>
  );
};

const ThreeScene = () => {
  return (
    <div style={{ 
      // width: '60vw', height: '60vh', background: '#748f9b' 
      height: '100%'
    }}>
      <Canvas camera={{ position: [1, 1, 1] }}>
        <Stats />
        <Scene />
      </Canvas>
    </div>
  );
};

export default ThreeScene;
