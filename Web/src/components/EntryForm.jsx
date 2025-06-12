import { useState } from "react";
import api from "../services/api";

const EntryForm = ({ onClose, onSuccess }) => {
  const [data, setData] = useState("");
  const [descricao, setDescricao] = useState("");
  const [tipo, setTipo] = useState("");
  const [valor, setValor] = useState("");

  const [errorMessage, setErrorMessage] = useState("");
  const [successMessage, setSuccessMessage] = useState("");

  async function handleSubmit(e) {
    e.preventDefault();
    setErrorMessage("");
    setSuccessMessage("");

    const formatarData = (dataISO) => {
      const [ano, mes, dia] = dataISO.split("-");
      return `${dia}/${mes}/${ano}`;
    };

    try {
      await api.post("/entry", {
        data: formatarData(data),
        descricao,
        tipo,
        valor,
      });

      setSuccessMessage("Lançamento cadastrado com sucesso!");
      setData("");
      setDescricao("");
      setTipo("");
      setValor("");

      if (onSuccess) onSuccess();
      setTimeout(() => {
        onClose();
      }, 1500);
    } catch (error) {
      if (error.response && error.response.status === 422) {
        setErrorMessage(error.response.data.message);
      } else {
        setErrorMessage(
          error.response?.data?.message ||
            "Erro ao cadastrar lançamento. Tente novamente."
        );
      }
    }
  }

  const handleBackdropClick = (e) => {
    if (e.target === e.currentTarget) {
      onClose();
    }
  };

  return (
    <div
      className="fixed inset-0 z-10 flex items-center justify-center bg-neutral-900"
      onClick={handleBackdropClick}
    >
      <div className="md:outline-2 md:outline-neutral-800 w-full md:w-1/2 lg:w-1/4 rounded-md p-6 md:p-12 md:bg-black/25">
        <h2 className="text-white text-xl mb-12">Cadastrar Lançamento</h2>

        {/* Mensagens de erro e sucesso */}

        {errorMessage && (
          <div className="mb-4 p-3 bg-red-500/20 border border-red-500 rounded-md text-red-400 text-sm">
            {errorMessage}
          </div>
        )}
        {successMessage && (
          <div className="mb-4 p-3 bg-green-500/20 border border-green-500 roundend-md text-green-400 text-sm">
            {successMessage}
          </div>
        )}

        <form onSubmit={handleSubmit}>
          <div className="mb-8 flex flex-col gap-2">
            <label className="text-neutral-400">Data</label>
            <input
              type="date"
              className="outline outline-neutral-700 text-neutral-600 uppercase p-2.5 rounded-md focus:outline-purple-400 focus:text-white"
              value={data}
              onChange={(e) => setData(e.target.value)}
              required
              tabIndex="1"
            />
          </div>
          <div className="mb-8 flex flex-col gap-2">
            <label className="text-neutral-400">Descrição</label>
            <input
              type="text"
              className="outline outline-neutral-700 text-neutral-600 p-2.5 rounded-md focus:outline-purple-400 focus:text-white"
              value={descricao}
              onChange={(e) => setDescricao(e.target.value)}
              required
              tabIndex="2"
              placeholder="Descreva seu lançamento"
            />
          </div>

          <div className="mb-8 flex flex-col gap-2">
            <label className="text-neutral-400">Tipo</label>
            <select
              value={tipo}
              onChange={(e) => setTipo(e.target.value)}
              className="outline outline-neutral-700 text-neutral-600 p-2.5 rounded-md focus:outline-purple-400 focus:text-white"
              required
              tabIndex="3"
            >
              <option value="" className="bg-neutral-900">
                Selecione
              </option>
              <option value="entrada" className="bg-neutral-900">
                Entrada
              </option>
              <option value="saida" className="bg-neutral-900">
                Saída
              </option>
            </select>
          </div>
          <div className="mb-8 flex flex-col gap-2">
            <label className="text-neutral-400">Valor (R$)</label>
            <input
              type="number"
              step="0.01"
              placeholder="0.01"
              value={valor}
              onChange={(e) => setValor(e.target.value)}
              className="outline outline-neutral-700 text-neutral-600 p-2.5 rounded-md focus:outline-purple-400 focus:text-white"
              required
              tabIndex="4"
            />
          </div>
          <div className="flex items-center justify-between gap-5">
            <button
              type="submit"
              className="text-center bg-purple-400 rounded-md w-full py-2.5 font-semibold hover:bg-purple-500 transition-all duration-200 ease cursor-pointer text-white"
            >
              Salvar
            </button>
            <button
              type="button"
              onClick={onClose}
              className="text-center bg-neutral-800 w-full rounded-md py-2.5 font-semibold text-neutral-400 cursor-pointer transition-all duration-200 ease hover:text-white hover:bg-neutral-600"
            >
              Cancelar
            </button>
          </div>
        </form>
      </div>
    </div>
  );
};

export default EntryForm;
