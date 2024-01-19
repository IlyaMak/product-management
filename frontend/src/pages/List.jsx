import {useEffect, useState} from "react";
import RestApiClient from "../services/RestApiClient";

export default function List() {
  const [products, setProducts] = useState([]);
  useEffect(() => {
    RestApiClient.index()
      .then((response) => response.json())
      .then((json) => setProducts(json));
  }, []);

  return products.map((product, index) => (<div key={index}>{product.name}</div>));
}