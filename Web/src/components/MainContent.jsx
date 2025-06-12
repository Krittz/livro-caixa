import { ArrowDownCircle, ArrowUpCircle, DollarSign } from "lucide-react";
import Card from "./ui/Card";
import Entries from "../views/Entries";
import { useEffect, useState } from "react";
import api from "../services/api";

const MainContent = () => {
  const [summary, setSummary] = useState(null);

  useEffect(() => {
    async function fetchSummary() {
      try {
        const response = await api.get("/sumary");
        setSummary(response.data.data);
      } catch (error) {
        console.error("Erro ao buscar resumo financeiro:", error);
      }
    }

    fetchSummary();
  }, []);

  const stats = summary
    ? [
        {
          title: "Entradas",
          value: `${Number(summary.total_entradas).toLocaleString("pt-BR", {
            style: "currency",
            currency: "BRL",
          })}`,
          change: `${summary.changes.entradas}`,
          icon: ArrowUpCircle,
          iconColor: "text-green-500",
        },
        {
          title: "Saídas",
          value: `${Number(summary.total_saidas).toLocaleString("pt-BR", {
            style: "currency",
            currency: "BRL",
          })}`,
          change: `${summary.changes.saidas}`,
          icon: ArrowDownCircle,
          iconColor: "text-red-500",
        },
        {
          title: "Caixa Atual",
          value: `R$ ${Number(summary.caixa_atual).toLocaleString("pt-BR", {
            currency: "BRL",
          })}`,
          change: `${summary.changes.caixa}`,
          icon: DollarSign,
          iconColor: "text-indigo-500",
        },
      ]
    : [];

  return (
    <main className="p-6">
      {/* Stats Grid */}
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        {stats.map((stat, index) => (
          <Card key={index} {...stat} />
        ))}
      </div>

      {/* Content Area */}
      <div className="grid grid-cols-1 lg:grid-cols-1 gap-6">
        <Entries />
      </div>
    </main>
  );
};

export default MainContent;
