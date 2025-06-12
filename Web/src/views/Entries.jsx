import { MoreVertical, Plus, Search } from "lucide-react";
import { useEffect, useState } from "react";
import api from "../services/api";
import EntryForm from "../components/EntryForm";

const Entries = () => {
  const [showModal, setShowModal] = useState(false);
  const [entries, setEntries] = useState([]);
  const [loading, setLoading] = useState(true);
  const [search, setSearch] = useState("");
  const [tipo, setTipo] = useState("");

  async function fetchEntries(query = "", tipoFiltro = "") {
    setLoading(true);

    try {
      const params = {};
      if (query.trim() !== "") params.descricao = query;
      if (tipoFiltro) params.tipo = tipoFiltro;

      const response = await api.get("/entry", { params });
      setEntries(response.data.data);
    } catch (error) {
      console.error("Erro ao buscar lançamentos:", error);
    } finally {
      setLoading(false);
    }
  }

  useEffect(() => {
    fetchEntries();
  }, []);

  useEffect(() => {
    const timeout = setTimeout(() => {
      fetchEntries(search, tipo);
    }, 500);
    return () => clearTimeout(timeout);
  }, [search, tipo]);

  return (
    <div className="rounded-lg overflow-hidden w-full flex items-center flex-col">
      {/* TOPO */}
      <div className="flex justify-between bg-neutral-800 w-full  md:rounded-md p-2 mb-2">
        <form
          onSubmit={(e) => e.preventDefault()}
          className="flex items-center gap-5"
        >
          <div className="bg-neutral-900/75 inline-flex items-center rounded-md px-2 text-neutral-600 gap-2">
            <Search size={18} />
            <input
              type="search"
              placeholder="Buscar"
              value={search}
              onChange={(e) => setSearch(e.target.value)}
              className="bg-transparent focus:outline-none text-neutral-600 py-2"
            />
          </div>

          <div className="flex flex-col items-start">
            <span className="text-xs text-neutral-400">Filtrar por</span>
            <select
              value={tipo}
              onChange={(e) => setTipo(e.target.value)}
              className="bg-neutral-900 text-neutral-300 rounded-md px-2 py-1"
            >
              <option value="">Tipo</option>
              <option value="entrada">Entrada</option>
              <option value="saida">Saída</option>
            </select>
          </div>
        </form>

        <div className="flex items-center gap-2 text-white">
          <button
            onClick={() => setShowModal(true)}
            className="cursor-pointer p-2 rounded-md hover:bg-neutral-700"
          >
            <Plus size={18} />
          </button>
        </div>
      </div>

      {/* TABELA */}

      <table className="w-full ">
        <thead>
          <tr className="border-b border-neutral-700 text-neutral-600">
            <th className="p-4 "></th>
            <th className="p-4 text-left">ID</th>
            <th className="p-4 text-left">Data</th>
            <th className="p-4 text-left">Descrição</th>
            <th className="p-4 text-left">Tipo</th>
            <th className="p-4 text-left">Valor</th>
            <th className="p-4 "></th>
          </tr>
        </thead>
        <tbody>
          {loading ? (
            <tr>
              <td colSpan={7} className="text-center text-neutral-500 py-8">
                Carregando...
              </td>
            </tr>
          ) : entries.length === 0 ? (
            <tr>
              <td colSpan={7} className="text-center text-neutral-500 py-8">
                Nenhum lançamento encontrado.
              </td>
            </tr>
          ) : (
            entries.map((entry) => (
              <tr
                key={entry.id}
                className="border-b border-neutral-700 hover:bg=neutral-500 transition-all duration-200 ease text-neutral-400"
              >
                <td className="p-4"></td>
                <td className="p-4">#{entry.id}</td>
                <td className="p-4">{entry.data}</td>
                <td className="p-4">{entry.descricao}</td>
                <td className="p-4 capitalize">{entry.tipo}</td>
                <td className="p-4">{entry.valor}</td>
                <td className="p-4">
                  <button className="p-2 rounded-md hover>bg-neutral-700">
                    <MoreVertical size={16} />
                  </button>
                </td>
              </tr>
            ))
          )}
        </tbody>
      </table>

      {showModal && (
        <EntryForm
          onClose={() => setShowModal(false)}
          onSuccess={fetchEntries}
        />
      )}
    </div>
  );
};
export default Entries;
